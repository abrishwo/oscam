<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function products()
    {
        return view('admin.products.index');
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function editProduct($id)
    {
        return view('admin.products.edit', ['id' => $id]);
    }
}
