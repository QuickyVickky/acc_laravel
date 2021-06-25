<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBanks extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'account_category_id',
        'name',
        'account_id',
        'description',
        'is_active',
        'admin_id',
        'is_editable',
        'payment_method',
    ];

    protected $table = 'accounts_or_banks';

    public function account_category(){
        return $this->hasOne(AccountCategory::class, 'id', 'account_category_id');
    }
    public function transaction_accounts(){
        return $this->hasMany(Transaction::class, 'accounts_or_banks_id', 'id');
    }

    public function transaction_accounts_sum(){
        return $this->hasMany(Transaction::class, 'accounts_or_banks_id', 'id')->selectRaw('SUM(amount) as payment_amount');
    }

}
