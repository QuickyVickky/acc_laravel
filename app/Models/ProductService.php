<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'sub_category',
        'name',
        'description',
        'price',
        'tax_id',
        'admin_id',
        'is_active',
    ];

    protected $table = 'products_or_services';

    public function sub_category(){
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function tax(){
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

}
