<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\StatusDonHang;
use App\Models\Order;
use App\Models\InvoiceDetail;
use App\Models\OrderAction;

class InvoiceController extends Controller
{
    public function __construct(){
        $this->middleware('permission:Xem hóa đơn', ['only' => ['index', 'show']]);
    }
    public function index()
    {
        $invoices = Invoice::with('status')->orderBy('created_at', 'desc')->paginate(6);
        $notifications = OrderAction::orderBy('created_at', 'desc') // Sắp xếp theo thời gian
        ->limit(10) // Giới hạn số lượng thông báo hiển thị
        ->get();
        $unreadCount = OrderAction::where('is_read', false)->count();
        return view('admin.invoices.index', compact('invoices', 'notifications', 'unreadCount'));

    }

    public function show($id)
    {   
        $invoice = Invoice::with('status')->findOrFail($id);
        // foreach ($invoice->invoiceDetails as => $detail) {
        //     dd($detail); // Dừng lại và kiểm tra detail đầu tiên
        // }
        $notifications = OrderAction::orderBy('created_at', 'desc') // Sắp xếp theo thời gian
        ->limit(10) // Giới hạn số lượng thông báo hiển thị
        ->get();
        $unreadCount = OrderAction::where('is_read', false)->count();
        return view('admin.invoices.show', compact('invoice', 'notifications', 'unreadCount'));
    }
    
}