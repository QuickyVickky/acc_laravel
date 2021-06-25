<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'vendor_id',
        'bill_notes',
        'bill_number',
        'bill_date',
        'is_active',
        'payment_due_date',
        'admin_id',
        'total_qty',
        'subtotal',
        'tax_total',
        'total',
        'bill_status',
        'amount_due',
        'total_paid',

    ];

    protected $table = 'bills';

    public function bills_item(){
        return $this->hasMany(BillsItem::class, 'bill_id', 'id');
    }

	public function vendor(){
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }


}
