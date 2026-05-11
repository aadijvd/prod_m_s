<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;


class OrderController extends Controller
{

    //******************************************************** Orders List
    public function index()
    {
        $orders = Order::latest()->get();

        return view('admin.orders', compact('orders'));
    }

    //******************************************************** Update Status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // old status
        $oldStatus = $order->status;

        // new status
        $newStatus = $request->status;

        // update order
        $order->status = $newStatus;
        $order->save();

        /*
        |--------------------------------------------------------------------------
        | Reduce stock ONLY when delivered first time
        |--------------------------------------------------------------------------
        */

        if (
            $oldStatus != 'delivered' && //   ***   prevent stock reducing multiple times   ***
            $newStatus == 'delivered'
        ) {

            $items = json_decode($order->items, true);

            foreach ($items as $item) {

                $product = Product::find($item['product_id']);

                if ($product) {

                    $product->qty -= $item['qty'];

                    // prevent negative stock
                    if ($product->qty < 0) {
                        $product->qty = 0;
                    }

                    $product->save();
                }
            }
        }

        return back()->with(
            'success',
            'Order status updated successfully'
        );
    }
}
