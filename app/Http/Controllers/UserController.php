<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    // Y los demás métodos que necesites (index, store, etc.)
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('users.index', compact('users'));
    }
}
