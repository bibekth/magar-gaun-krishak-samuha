<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'year', 'month', 'savings', 'down_payment_amount', 'interest', 'fined', 'total_collected_amount'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSavingsAttribute($value){
        return intval($value);
    }

    public function getDownPaymentAmountAttribute($value){
        return intval($value);
    }

    public function getInterestAttribute($value){
        return intval($value);
    }

    public function getFinedAttribute($value){
        return intval($value);
    }

    public function getTotalCollectedAmountAttribute($value){
        return intval($value);
    }
}
