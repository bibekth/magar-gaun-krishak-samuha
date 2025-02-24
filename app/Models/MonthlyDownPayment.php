<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyDownPayment extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','down_payment_amount','year','month'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDownPaymentAmountAttribute($value){
        return intval($value);
    }
}
