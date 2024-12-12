<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_name',
        'color',
        'size',
        'quantity',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);  // Liên kết với bảng 'invoices'
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_name', 'name');  // Liên kết với bảng 'products'
    }
}
