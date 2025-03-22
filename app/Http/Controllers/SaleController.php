<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search') && $request->search !== null) {
            $search = strtolower($request->search);
            $sales = Sale::whereRaw('LOWER(invoice_number) LIKE ?', ['%'.$search.'%'])
                ->paginate(10)
                ->appends($request->only('search'));
        } else {
            $sales = Sale::latest()->paginate(10);
        }
        
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        $members = Member::all();
        return view('sales.create', compact('products', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_data' => 'required|array|min:1',
            'product_data.*.product_id' => 'required|exists:products,id',
            'product_data.*.quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric',
            'payment_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
        ]);

        $invoiceNumber = 'INV-' . strtoupper(Str::random(8));

        Sale::create([
            'id' => Str::uuid(),
            'invoice_number' => $invoiceNumber,
            'user_id' => Auth::user()->id,
            'member_id' => $request->member_id,
            'product_data' => json_encode($request->product_data),
            'total_amount' => $request->total_amount,
            'payment_amount' => $request->payment_amount,
            'change_amount' => $request->change_amount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('sales.index')->with('message', 'Sale created successfully!');
    }

    public function show(Sale $sale)
    {
        $sale->product_data = json_decode($sale->product_data, true);
        return view('sales.show', compact('sale'));
    }
}
