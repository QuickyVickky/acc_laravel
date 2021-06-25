<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'current_tax_rate',
        'abbreviation',
        'details',
        'is_editable',
        'is_active',
    ];

    protected $table = 'tax';
    
}
