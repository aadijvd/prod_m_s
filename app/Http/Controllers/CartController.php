<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class CartController extends Controller
{

    //******************************************************** Show Cart
    public function show()
    {
        $cart = session('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        return view('cart', compact('cart', 'total'));
    }

    //******************************************************** Add to Cart
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->id);

        // checking stock if SIMPLEPIE_LOWERCASE
        if ($product->qty <= 0) {

            return response()->json([
                'success' => false,
                'message' => 'Out of stock'
            ]);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            //    *********     Prevent Cart Qty > Product Qty     *********    
            if ($cart[$product->id]['qty'] < $product->qty) {
                $cart[$product->id]['qty'] += 1;
            }
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id, //to update stock in order table later
                "name" => $product->item_name,
                "price" => $product->sale,
                "image" => $product->image,
                "qty" => 1
            ];
        }

        session()->put('cart', $cart);
        $count = array_sum(array_column($cart, 'qty'));
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    //******************************************************** Upadte Cart Qty
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart');

        if (isset($cart[$request->id])) {
            $cart[$request->id]['qty'] = $request->qty;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }


    //********************************************************  Remove Cart Qty
    public function removeCart(Request $request)
    {
        $cart = session()->get('cart');

        unset($cart[$request->id]);

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    //********************************************************  Check Out
    public function checkout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty');
        }

        // total
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        // save order
        Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'items' => json_encode($cart),
            'total' => $total,
            'status' => 'pending'
        ]);

        // clear cart
        session()->forget('cart');

        // redirect
        return redirect()
            ->route('products.visitor')
            ->with('success', 'Order placed successfully');
    }
}
