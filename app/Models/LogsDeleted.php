<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsDeleted extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'data',
    ];

    protected $table = 'logs_deleted';

}
