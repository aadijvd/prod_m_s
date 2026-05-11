<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SaleItem;

class SaleController extends Controller
{
    // ************************************************Show all Sale
    public function index()
    {
        $sales = Sale::with('customer')->get();
        return view('admin.sales', compact('sales'));
    }

    // ************************************************Show add purchase form
    public function create()
    {
        $customers = Customer::all(); //to show customer to select
        $products = Product::all(); // to show products to select
        return view('admin.add-sale', compact('customers', 'products'));
    }

    // ************************************************** Store sale and sale item and redirect
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'invoice_no' => 'required|string|unique:sales,invoice_no',
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',

            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',

            'discount_amount' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',

            'payment_status' => 'required|in:pending,partial,paid',
            'payment_method' => 'required|in:cash,card,bank',

            'notes' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.qty' => 'nullable|numeric|min:1',
            'items.*.price' => 'nullable|numeric|min:0',
        ]);

        // 2. Filter valid items (same logic as purchase)
        $validItems = collect($request->items)->filter(function ($item) {
            return !empty($item['product_id'])
                && !empty($item['qty'])
                && !empty($item['price'])
                && $item['qty'] > 0
                && $item['price'] >= 0;
        });

        if ($validItems->isEmpty()) {
            return back()
                ->withErrors(['items' => 'Please select at least one product with qty and price'])
                ->withInput();
        }

        // 3. Transaction
        DB::transaction(function () use ($request, $validItems) {

            // Create Sale
            $sale = Sale::create([
                'invoice_no' => $request->invoice_no,
                'customer_id' => $request->customer_id,
                'sale_date' => $request->sale_date,

                'total_amount' => 0,
                'paid_amount' => $request->paid_amount ?? 0,
                'due_amount' => $request->due_amount ?? 0,

                'discount_amount' => $request->discount_amount ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,

                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,

                'notes' => $request->notes,
                'created_by' => auth()->user()->id,
            ]);

            $totalAmount = 0;

            foreach ($validItems as $item) {

                $qty = (float) $item['qty'];
                $price = (float) $item['price'];

                $subtotal = $qty * $price;
                $totalAmount += $subtotal;

                // 1. Create Sale Item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // 2. Reduce stock
                $product = Product::findOrFail($item['product_id']);

                if ($product->qty < $qty) {
                    throw new \Exception("Not enough stock for product: " . $product->item_name);
                }

                $product->decrement('qty', $qty);
            }

            // 3. Update total
            $sale->update([
                'total_amount' => $totalAmount
            ]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully!');
    }

    // ************************************************** Show sale item page
    public function show($id)
    {
        $sale = Sale::with(['customer', 'items.product', 'user'])
            ->findOrFail($id);

        return view('admin.sale-items', compact('sale'));
    }

    // ************************************************** Show edit sale item page

    public function edit($id)
    {
        $sale = Sale::with(['items.product'])->findOrFail($id);
        $customers = Customer::all();

        return view('admin.edit-sale', compact('sale', 'customers'));
    }

    // ************************************************** Update sale and sale item page
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'payment_status' => 'required|in:paid,partial,pending',
            'payment_method' => 'required|in:cash,card,bank',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Load sale with old items
        $sale = Sale::with('items')->findOrFail($id);

        // 🔴 STEP 1: CALCULATE STOCK CHANGES
        $stockChanges = [];

        // ✅ Reverse old sale (add stock back)
        foreach ($sale->items as $oldItem) {
            $stockChanges[$oldItem->product_id] =
                ($stockChanges[$oldItem->product_id] ?? 0) + $oldItem->qty;
        }

        // ❌ Apply new sale (subtract stock)
        foreach ($request->items as $item) {
            $stockChanges[$item['product_id']] =
                ($stockChanges[$item['product_id']] ?? 0) - $item['qty'];
        }

        // 🔴 STEP 2: VALIDATE STOCK
        foreach ($stockChanges as $productId => $change) {

            $product = Product::find($productId);
            if (!$product) continue;

            $futureStock = $product->qty + $change;

            if ($futureStock < 0) {
                return back()->with(
                    'error',
                    "Not enough stock for product ID: $productId"
                );
            }
        }

        // 🔴 STEP 3: DELETE OLD ITEMS
        $sale->items()->delete();

        // 🔴 STEP 4: APPLY STOCK CHANGES
        foreach ($stockChanges as $productId => $change) {

            $product = Product::find($productId);
            if (!$product) continue;

            $product->qty += $change;
            $product->save();
        }

        // 🟢 STEP 5: UPDATE SALE
        $sale->update([
            'customer_id' => $request->customer_id,
            'sale_date' => $request->sale_date,
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        // 🟢 STEP 6: INSERT NEW ITEMS
        $total = 0;

        foreach ($request->items as $item) {

            $subtotal = $item['qty'] * $item['price'];
            $total += $subtotal;

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);
        }

        // 🟢 STEP 7: UPDATE TOTALS
        $sale->update([
            'total_amount' => $total,
            'due_amount' => $total - $request->paid_amount,
            'paid_amount' => $request->paid_amount,
        ]);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully!');
    }

    // ************************************************** Delete sale
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            // 1. Load sale with items
            $sale = Sale::with('items')->findOrFail($id);

            // 2. Validate stock (optional but smart)
            foreach ($sale->items as $item) {

                $product = Product::find($item->product_id);
                if (!$product) continue;

                // after deleting sale → stock will increase
                $futureStock = $product->qty + $item->qty;

                // usually no issue here, but keeping for safety
                if ($futureStock < 0) {
                    throw new \Exception(
                        "Stock error for product ID {$item->product_id}"
                    );
                }
            }

            // 3. Reverse stock (add back sold qty)
            foreach ($sale->items as $item) {

                $product = Product::find($item->product_id);
                if (!$product) continue;

                $product->increment('qty', $item->qty);
            }

            // 4. Delete sale (items auto-delete via cascade)
            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully!');
    }
}
