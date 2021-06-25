<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'fullname',
        'firstname',
        'lastname',
        'email',
        'mobile',
        'is_active',
        'admin_id',
        
    ];

    protected $table = 'vendors';

    

}
