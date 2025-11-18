<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Scan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

/**
 * Controller for the admin panel.
 */
class AdminController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('admin.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the products page.
     *
     * @return \Illuminate\View\View
     */
    public function products()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the create product page.
     *
     * @return \Illuminate\View\View
     */
    public function createProduct()
    {
        return view('admin.products.create');
    }

    /**
     * Show the edit product page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editProduct($id)
    {
        return view('admin.products.edit', ['id' => $id]);
    }

    /**
     * Show the import products page.
     *
     * @return \Illuminate\View\View
     */
    public function importProducts()
    {
        return view('admin.products.import');
    }

    /**
     * Process the import.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processImport(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.products.index');
    }

    /**
     * Show the scan logs page.
     *
     * @return \Illuminate\View\View
     */
    public function scanLogs()
    {
        $scans = Scan::with('product')->get();
        return view('admin.scan-logs.index', compact('scans'));
    }
}
