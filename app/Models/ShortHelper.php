<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortHelper extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'short',
        'details',
        'type',
        'classhtml',
        'is_active',
    ];

    protected $table = 'short_helper';
    
}
