<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'fullname',
        'email',
        'mobile',
        'is_active',
        'role',
    ];

    protected $table = 'admins';
    
}
