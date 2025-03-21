<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemainingDebt extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','debt_amount','unpaid_months'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDebtAmountAttribute($value){
        return intval($value);
    }
}
