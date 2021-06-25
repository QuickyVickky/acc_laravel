<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'invoice_id',
        'products_or_services_id',
        'description',
        'qty',
        'price',
        'is_active',
        'amount',
        'totaltax',
        'tax_id',
        'tax_rate',
    ];

    protected $table = 'invoice_items';

    public function productnservice(){
        return $this->hasOne(ProductService::class, 'id', 'products_or_services_id');
    }


}
