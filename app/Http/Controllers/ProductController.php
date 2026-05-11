<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //*****************************************  display product page
    //*****************************************  display product page
    public function create()
    {
        //not using route name because not redirecting
        return view('admin.add-product');
    }

    //*****************************************  Add product
    //*****************************************  Add product
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'item_descr' => 'nullable|string',
            'cost' => 'required|numeric',
            'sale' => 'numeric',
            'unit' => 'required',
            'barcode' => 'required|string|unique:products,barcode',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'images' => 'nullable|array|max:5',                     //This validates the whole input field (the array itself)
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048', //This validates each file inside the array
        ], [
            'image.image' => 'Main file must be an image.',
            'image.mimes' => 'Main image must be jpeg, png, jpg or webp.',
            'image.max' => 'Main image must not exceed 5MB.',

            'images.max' => 'You can upload maximum 5 images.',

            'images.*.image' => 'Each gallery file must be an image.',
            'images.*.mimes' => 'Gallery images must be jpeg, png, jpg or webp.',
            'images.*.max' => 'Each gallery image must be under 5MB.',
        ]); //custom error messages (next project separate class)

        // 🔹 Save main image
        $mainImage = null;

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image')->store('products', 'public'); //final thing will give a path in var
        }

        $product = Product::create([
            'item_name' => $request->item_name,
            'item_descr' => $request->item_descr,
            'cost' => $request->cost,
            'sale' => $request->sale,
            'unit' => $request->unit,
            'barcode' => $request->barcode,
            'image' => $mainImage,
        ]);

        // 🔹 Save multiple images

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        // NOTE: RUN this ---- php artisan storage:link -------to fetch
        return redirect()->route('products.index');
    }

    //*****************************************   displaying admin product page
    public function index()
    {
        $products = Product::all();

        return view('admin.products', compact('products'));
    }


    //*****************************************   showing edit file display
    public function edit(Request $req, string $id)
    {
        // finding product with id
        // $product = Product::find($id);
        $product = Product::with('images')->findOrFail($id);
        return view('admin/update-product', compact('product'));
    }

    //*****************************************   update product
    public function updated(Request $req, string $id)
    {
        // finding product with id with ProductIMages
        $product = Product::with('images')->findOrFail($id);

        // 2. Check if exists
        // if (!$product) {
        //     return redirect('/admin/products')->with('error', 'Product not found');
        // } // with findorfail above no need for this check
        $req->validate([
            'item_name' => 'required|string',
            'qty' => 'required|integer|min:0',
            'item_descr' => 'nullable|string',
            'cost' => 'required|numeric',
            'sale' => 'numeric',
            'unit' => 'required',
            'barcode' => 'required|string|unique:products,barcode,' . $product->id, //to ignore for this id
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
            'images' => 'nullable|array|max:5',                     //This validates the whole input field (the array itself)
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048', //This validates each file inside the array 
        ], [
            'image.image' => 'Main file must be an image.',
            'image.mimes' => 'Main image must be jpeg, png, jpg or webp.',
            'image.max' => 'Main image must not exceed 5MB.',

            'images.max' => 'You can upload maximum 5 images.',

            'images.*.image' => 'Each gallery file must be an image.',
            'images.*.mimes' => 'Gallery images must be jpeg, png, jpg or webp.',
            'images.*.max' => 'Each gallery image must be under 5MB.',
        ]); //custom error messages (next project separate class));

        // updating fields
        $product->update([
            'item_name' => $req->item_name,
            'qty' => $req->qty,
            'item_descr' => $req->item_descr,
            'cost' => $req->cost,
            'sale' => $req->sale,
            'unit' => $req->unit,
            'barcode' => $req->barcode,
        ]);

        // If new image uploaded → delete old → save new and If not → keep old

        // Main Image Update
        if ($req->hasFile('image')) {

            // delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // store new image
            $newMainImage = $req->file('image')->store('products', 'public');
            $product->update([
                'image' => $newMainImage,
            ]);

            // update column
            //$product->image = $newMainImage;
            // $product->save();
        }

        // multiple images 👉 For now we use simple approach (replace all)
        // Multiple Images Update
        if ($req->hasFile('images')) {
            if ($product->images->count() > 0) {
                // delete old images (storage + DB)
                foreach ($product->images as $img) {

                    if (Storage::disk('public')->exists($img->image)) {
                        Storage::disk('public')->delete($img->image);
                    }

                    $img->delete();
                }
            }
            // store new images
            foreach ($req->file('images') as $file) {

                $path = $file->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path
                ]);
            }
        }

        return redirect()->route('products.index');
    }

    //*********************************************  Delete Product
    public function destroy($id)
    {
        // $product = Product::findOrFail($id);
        $product = Product::with('images')->findOrFail($id); //need images table also

        // 1. Delete main image (if exists)
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Delete multiple gallery images
        if ($product->images->count() > 0) {
            foreach ($product->images as $img) {

                if (Storage::disk('public')->exists($img->image)) {
                    Storage::disk('public')->delete($img->image);
                }

                $img->delete(); // delete DB record
            }
        }

        // 3. Delete product itself
        $product->delete();

        return redirect('/admin/products')->with('success', 'Product deleted successfully');;
    }
}
