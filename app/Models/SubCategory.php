<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'main_category_id',
        'name',
        'name2',
        'details',
        'is_editable',
        'is_active',
    ];

    protected $table = 'sub_category';

    public function main_category(){
        return $this->hasOne(MainCategory::class, 'id', 'main_category_id');
    }


    

}
