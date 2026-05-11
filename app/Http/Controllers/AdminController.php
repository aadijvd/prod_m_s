<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //from step 6 pdf file
    public function dashboard()
    {
        $users = User::where('role', 0)->get();
        return view('admin.dashboard', compact('users'));
    }

    //show user to admin
    public function create()
    {
        $users = User::all();
        return view('admin.manage-user', compact('users'));
    }
}
