<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinalSaving extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'total_savings'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
