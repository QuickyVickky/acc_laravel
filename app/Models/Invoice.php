<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'invoice_title',
        'invoice_description',
        'invoice_number',
        'invoice_date',
        'is_active',
        'payment_due_date',
        'admin_id',
        'invoice_comment',
        'footer_comment',
        'total_qty',
        'subtotal',
        'tax_total',
        'total',
        'invoice_status',
        'amount_due',
        'total_paid',

    ];

    protected $table = 'invoices';

    public function invoice_item(){
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

	public function customer(){
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function transaction(){
        return $this->hasMany(Transaction::class, 'invoice_id', 'id');
    }

    
}
