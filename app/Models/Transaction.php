<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'transaction_date',
        'amount',
        'payment_method',
        'accounts_or_banks_id',
        'accounts_or_banks_id_transfer_fromto',
        'is_active',
        'admin_id',
        'is_editable',
        'notes',
        'description',
        'is_reviewed',
        'transaction_type',
        'invoice_id',
        'bills_id',
        'sub_category_id',
    ];

    protected $table = 'transactions';

    public function payment_method_name(){
        return $this->hasOne(ShortHelper::class, 'short', 'payment_method')->where('is_active',constants('is_active_yes'))->where('type','payment_method');
    }

    public function account_banks(){
        return $this->hasOne(AccountBanks::class, 'id', 'accounts_or_banks_id');
    }

    public function sub_category(){
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }
    public function invoice(){
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
    
    public function bill(){
        return $this->hasOne(Bills::class, 'id', 'bills_id');
    }


}
