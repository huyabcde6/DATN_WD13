<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\StatusDonHang;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('status')->paginate(6);
        return view('admin.invoices.index', compact('invoices'));
        
    }

}