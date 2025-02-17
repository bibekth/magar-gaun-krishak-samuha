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
}
