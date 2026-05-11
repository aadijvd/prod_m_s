<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class UserController extends Controller
{
    //from step 6 pdf file
    public function dashboard()
    {
        $products = Product::all();
        // return view('user.dashboard', compact('products'));

        return redirect()->route('home');
    }

    // ********************************updating status of users
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // if checkbox is checked → 1, else → 0
        $user->status = $request->has('status') ? 1 : 0;

        $user->save();

        return redirect()->back();
    }
}
