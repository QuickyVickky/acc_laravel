<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'details',
        'level',
        'is_active',
        'path_to',
        'is_editable',
    ];

    protected $table = 'account_category';

    public function all_account_banks(){
        return $this->hasMany(AccountBanks::class, 'account_category_id', 'id');
    }

}
