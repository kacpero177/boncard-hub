<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Wyłączamy automatyczne zarządzanie czasem przez bazę danych
    public $timestamps = false;

    protected $fillable = [
        'card_id',
        'amount',
        'description',
        'created_at',  // Odblokowujemy możliwość ręcznego zapisu
        'updated_at',  // Odblokowujemy możliwość ręcznego zapisu
    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}