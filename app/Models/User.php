<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->wallet()->create([
                'balance' => 0, // starting balance
            ]);
        });
    }

    // Define the relationship with Wallet
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}