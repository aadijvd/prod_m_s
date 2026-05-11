<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // ********************************************showing customers page
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers', compact('customers'));
    }

    // ******************************************** showing add customer page
    public function create()
    {
        return view('admin.add-customer');
    }

    // ******************************************** adding customer to db
    public function store(Request $request) {
        // validate data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'type' => 'required|in:walk_in,regular,online',
        ]);
        
        // insert data
        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer added successfully!');
    }

    // ******************************************** SHOW EDIT customer Page
    public function edit($id) {
        $customer = Customer::find($id);
        return view('admin.edit-customer', compact('customer'));
    }

    // ******************************************** EDIT customer to db
    public function update(Request $request, $id) {
        $customer = Customer::findOrFail($id);

        // validate data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:customers,phone,' . $id,
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'type' => 'required|in:walk_in,regular,online',
        ]);
        
        // insert data
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully!');
    }

    // ********************************************************* Delete Supplier
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Supplier deleted successfully!');
    }

}
