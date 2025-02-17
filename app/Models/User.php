<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'member_id',
        'phone_number',
        'email',
        'password',
        'role_id',
        'token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function finalSaving()
    {
        return $this->hasOne(FinalSaving::class);
    }

    public function monthlyDownPayments()
    {
        return $this->hasMany(MonthlyDownPayment::class);
    }

    public function monthlyDownDebts()
    {
        return $this->hasMany(MonthlyInvestedDebt::class);
    }

    public function monthlyTransactions()
    {
        return $this->hasMany(MonthlyTransaction::class);
    }

    public function remainingDebt()
    {
        return $this->hasOne(RemainingDebt::class);
    }

    public function totalDebtCollected()
    {
        return $this->hasOne(TotalDebtCollection::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
