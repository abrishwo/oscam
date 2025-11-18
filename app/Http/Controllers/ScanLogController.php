<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Illuminate\Http\Request;

class ScanLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Scan::query();

        if ($request->has('batch_number')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('batch_number', $request->input('batch_number'));
            });
        }

        if ($request->has('status')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('status', $request->input('status'));
            });
        }

        if ($request->has('product_name')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('product_name', 'like', '%' . $request->input('product_name') . '%');
            });
        }

        return $query->with('product')->paginate();
    }
}
