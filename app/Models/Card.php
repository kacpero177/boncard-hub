<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'pin',
        'activation_date',
        'expiration_date',
        'balance',
        'is_active',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}