<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_name',
        'email',
        'mobile',
        'is_active',
        'country',
        'state',
        'city',
        'pincode',
        'address',
        'landmark',
        'invoice_logo',

    ];

    protected $table = 'company_configurations';


}
