<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'name2',
        'details',
        'is_editable',
        'is_active',
        'mainaccount_type',
    ];

    protected $table = 'main_category';


}
