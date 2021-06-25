<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillsItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'bill_id',
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

    protected $table = 'bill_items';

    public function productnservice(){
        return $this->hasOne(ProductService::class, 'id', 'products_or_services_id');
    }
}
