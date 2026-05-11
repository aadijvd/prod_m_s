<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;

class PurchaseController extends Controller
{
    // ************************************************Show all purchases
    public function index()
    {
        $purchases = Purchase::with('supplier')->get();
        return view('admin.purchases', compact('purchases'));
    }

    // ************************************************Show add purchase form
    public function create()
    {
        $suppliers = Supplier::all(); //to show supplier to select
        $products = Product::all(); // to show products to select
        return view('admin.add-purchase', compact('suppliers', 'products'));
    }

    // ************************************************** Store purchase and purchase item and redirect
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.qty' => 'nullable|numeric|min:1', //items.*.qty means all qty in array
            'items.*.price' => 'nullable|numeric|min:0',
        ]);

        // 2. Filter valid items
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

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'total_amount' => 0,
                'purchase_date' => $request->purchase_date,
                'notes' => $request->notes,
            ]);

            $totalAmount = 0;

            foreach ($validItems as $item) {

                $qty = (float) $item['qty'];
                $price = (float) $item['price'];

                $subtotal = $qty * $price;
                $totalAmount += $subtotal;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                Product::find($item['product_id'])->increment('qty', $qty);
            }

            $purchase->update([
                'total_amount' => $totalAmount
            ]);
        });

        return redirect()->route('purchase.index')
            ->with('success', 'Purchase added successfully!');
    }

    // ******************************************************** Show purchase Edit page
    public function edit($id)
    {
        /*
        What it loads:
        purchase ✅
        purchase_items ✅ (via items)
        products for each item ✅ (via items.product)
        */
        $purchase = Purchase::with(['items.product'])->findOrFail($id);
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.edit-purchase', compact('purchase', 'suppliers', 'products'));
    }

    // ************************************************ Update and redirect
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // exists:suppliers,id → must exist in suppliers table (id column)
            'total_amount' => 'required|numeric',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Load purchase with old items (from DB)
        $purchase = Purchase::with('items')->findOrFail($id); // items function in model

        // 🔴 STEP 1: CALCULATE STOCK CHANGES (virtual simulation only)
        $stockChanges = [];

        // reverse old stock virtually
        foreach ($purchase->items as $oldItem) {
            // subtract old stock (undo previous purchase effect)
            $stockChanges[$oldItem->product_id] =
                ($stockChanges[$oldItem->product_id] ?? 0) - $oldItem->qty;
        }

        // add new stock impact (apply new request items)
        foreach ($request->items as $item) {
            // combine old reversal + new addition
            $stockChanges[$item['product_id']] =
                ($stockChanges[$item['product_id']] ?? 0) + $item['qty'];
        }

        // 🔴 STEP 2: VALIDATE STOCK BEFORE MAKING ANY DB CHANGES
        foreach ($stockChanges as $productId => $change) {

            $product = Product::find($productId);

            if (!$product) continue; // safety check (product may be deleted)

            $futureStock = $product->qty + $change;

            // ❌ if stock becomes negative → stop update
            if ($futureStock < 0) {
                return back()->with(
                    'error',
                    "Not enough stock for product ID: $productId"
                );
            }
        }

        // 🔴 STEP 3: DELETE OLD ITEMS (DB cleanup after validation)
        $purchase->items()->delete(); // removes old purchase items safely

        // 🔴 STEP 4: APPLY STOCK CHANGES TO PRODUCTS (REAL DB UPDATE)
        foreach ($stockChanges as $productId => $change) {

            $product = Product::find($productId);

            if (!$product) continue;

            $product->qty = $product->qty + $change; // apply final calculated difference
            $product->save();
        }

        // 🟢 STEP 5: UPDATE PURCHASE MAIN DATA
        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'total_amount' => $request->total_amount,
            'purchase_date' => $request->purchase_date,
            'notes' => $request->notes,
        ]);

        // 🟢 STEP 6: INSERT NEW ITEMS (NO STOCK UPDATE HERE)
        $total = 0;

        foreach ($request->items as $item) {

            $subtotal = $item['qty'] * $item['price'];
            $total += $subtotal;

            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);

            // update product cost only (NOT stock)
            // $product = Product::find($item['product_id']);
            // if ($product) {
            //we will be making log col for cost changes then update cost col in product table separately
            //$product->cost = $item['price']; // latest purchase price
            // $product->save();
            // }
        }

        // update final calculated total
        $purchase->update([
            'total_amount' => $total
        ]);

        return redirect()->route('purchase.index')
            ->with('success', 'Purchase updated successfully!');
    }

    // **************************************************** Delete and redirect
    // public function destroy($id)
    // {
    //     $purchase = Purchase::findOrFail($id);
    //     $purchase->delete();

    //     return redirect()->route('purchase.index')
    //         ->with('success', 'Purchase deleted successfully!');
    // }
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            // 1. Load purchase with items
            $purchase = Purchase::with('items')->findOrFail($id);

            // 2. Validate stock (optional but recommended)
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);

                if (!$product) continue;

                $futureStock = $product->qty - $item->qty;

                if ($futureStock < 0) {
                    throw new \Exception(
                        "Cannot delete: stock would go negative for product ID {$item->product_id}"
                    );
                }
            }

            // 3. Reverse stock
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);

                if (!$product) continue;

                $product->decrement('qty', $item->qty);
            }

            // 4. Delete purchase (items auto-delete via cascade)
            $purchase->delete();
        });

        return redirect()->route('purchase.index')
            ->with('success', 'Purchase deleted successfully!');
    }

    // ***************************************************** SHOW PURCHASE ITEM PAGE
    public function show($id)
    {
        //$purchase = Purchase::with('supplier')->findOrFail($id);

        $purchase = Purchase::with(['supplier', 'items.product'])->findOrFail($id);

        return view('admin.purchase-detail', compact('purchase'));
    }
    
}
