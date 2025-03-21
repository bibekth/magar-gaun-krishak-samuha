<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyInvestedDebt extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','year','month','debt_amount','charges','final_amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getDebtAmountAttribute($value){
        return intval($value);
    }

    public function getChargesAttribute($value){
        return intval($value);
    }

    public function getFinalAmountAttribute($value){
        return intval($value);
    }
}
