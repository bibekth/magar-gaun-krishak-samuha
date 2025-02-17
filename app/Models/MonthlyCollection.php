<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyCollection extends Model
{
    use SoftDeletes;
    protected $fillable = ['year','month','total_collected_amount'];
}
