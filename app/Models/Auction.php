<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Auction extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'starting_price',
        'ends_at',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
