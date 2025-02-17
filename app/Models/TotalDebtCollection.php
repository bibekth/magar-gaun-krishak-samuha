<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TotalDebtCollection extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'total_debt_collected_till_now'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
