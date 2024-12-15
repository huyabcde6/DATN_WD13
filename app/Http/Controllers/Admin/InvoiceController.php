<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\StatusDonHang;
use App\Models\Order;
use App\Models\InvoiceDetail;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('status')->orderBy('created_at', 'desc')->paginate(6);
        return view('admin.invoices.index', compact('invoices'));
        
    }

    public function show($id)
    {
        $invoice = Invoice::with('status')->findOrFail($id);
        return view('admin.invoices.show', compact('invoice'));
        
    }

}