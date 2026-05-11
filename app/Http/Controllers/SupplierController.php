<?php

namespace App\Http\Controllers;

use App;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // ********************************************displaying suppliers
    public function index()
    {
        $suppliers = Supplier::all();

        return view('admin.suppliers', compact('suppliers'));
    }

    // ********************************************Show Add Supplier form
    public function create()
    {
        return view('admin.add-supplier');
    }

    // ********************************************Store supplier in database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:suppliers,phone_number',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Supplier::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // return redirect('/admin/suppliers')->with('success', 'Supplier added successfully!');
        return redirect()->route('admin.supplier')->with('success', 'Supplier added successfully!');
    }

    // ******************************************* Show supplier edit page
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.edit-supplier', compact('supplier'));
    }

    // ******************************************* update supplier
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:suppliers,phone_number,' . $id, //$id to ignore unique for this id
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.supplier')
            ->with('success', 'Supplier updated successfully!');
    }

    // ********************************************************* Delete Supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.supplier')
            ->with('success', 'Supplier deleted successfully!');
    }
}
