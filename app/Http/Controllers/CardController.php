<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CardController extends Controller
{
    /**
     * Wyświetlanie listy kart (Dashboard) z filtrami i statystykami
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $now = Carbon::now('Europe/Warsaw')->format('Y-m-d H:i:s');

        $stats = [
            'total_balance'   => Card::sum('balance'),
            'total_cards'     => Card::count(),
            'active_cards'    => Card::where('is_active', true)->where('expiration_date', '>', $now)->count(),
            'expired_cards'   => Card::where('expiration_date', '<=', $now)->count(),
            'blocked_cards'   => Card::where('is_active', false)->count(),
        ];

        $query = Card::query();

        if (!empty($search)) {
            $cleanSearch = str_replace(' ', '', $search);
            $query->where('card_number', 'like', "%{$cleanSearch}%");
        }

        if (!empty($status)) {
            if ($status === 'active') {
                $query->where('is_active', true)->where('expiration_date', '>', $now);
            } elseif ($status === 'expired') {
                $query->where('expiration_date', '<=', $now);
            } elseif ($status === 'blocked') {
                $query->where('is_active', false);
            }
        }

        $cards = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('index', compact('cards', 'stats'));
    }

    /**
     * Wyświetlanie formularza tworzenia karty
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Zapisywanie nowej karty w bazie danych z limitem kwoty
     */
    public function store(Request $request)
    {
        $request->validate([
            'card_number'     => 'required|string|size:20|unique:cards,card_number',
            'pin'             => 'required|string|size:4',
            'balance'         => 'required|numeric|min:0|max:999999999',
            'activation_date' => 'required|date',
            'expiration_date' => 'required|date|after:activation_date',
        ]);

        $polskiCzas = Carbon::now('Europe/Warsaw')->format('Y-m-d H:i:s');

        $activationDate = Carbon::parse($request->input('activation_date'))->format('Y-m-d H:i:s');
        $expirationDate = Carbon::parse($request->input('expiration_date'))->format('Y-m-d H:i:s');

        $card = Card::create([
            'card_number'     => $request->input('card_number'),
            'pin'             => $request->input('pin'),
            'balance'         => $request->input('balance'),
            'activation_date' => $activationDate,
            'expiration_date' => $expirationDate,
            'is_active'       => true,
            'created_at'      => $polskiCzas,
            'updated_at'      => $polskiCzas,
        ]);

        Transaction::create([
            'card_id'     => $card->id,
            'description' => 'Initial card activation and deposit',
            'amount'      => $card->balance,
            'created_at'  => $polskiCzas,
            'updated_at'  => $polskiCzas,
        ]);

        return redirect('/dashboard')->with('success', 'Gift card has been successfully registered!');
    }

    /**
     * Wyświetlanie formularza edycji karty
     */
    public function edit($id)
    {
        $card = Card::findOrFail($id);
        return view('edit', compact('card'));
    }

    /**
     * Aktualizacja parametrów karty z bezpiecznym limitem kwoty i separatorem linii
     */
    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);

        $request->validate([
            'card_number'     => 'required|string|size:20|unique:cards,card_number,' . $card->id,
            'pin'             => 'required|string|size:4',
            'balance'         => 'required|numeric|min:0|max:999999999',
            'activation_date' => 'required|date',
            'expiration_date' => 'required|date|after:activation_date',
        ]);

        $oldCardNumber = $card->card_number;
        $oldPin = $card->pin;
        $oldBalance = (float)$card->balance;
        $oldActivation = Carbon::parse($card->activation_date)->format('Y-m-d H:i:s');
        $oldExpiration = Carbon::parse($card->expiration_date)->format('Y-m-d H:i:s');

        $newActivation = Carbon::parse($request->input('activation_date'))->format('Y-m-d H:i:s');
        $newExpiration = Carbon::parse($request->input('expiration_date'))->format('Y-m-d H:i:s');
        $newBalance = (float)$request->input('balance');

        $polskiCzas = Carbon::now('Europe/Warsaw')->format('Y-m-d H:i:s');

        $card->update([
            'card_number'     => $request->input('card_number'),
            'pin'             => $request->input('pin'),
            'balance'         => $newBalance,
            'activation_date' => $newActivation,
            'expiration_date' => $newExpiration,
            'updated_at'      => $polskiCzas,
        ]);

        $changes = [];
        
        if ($oldCardNumber !== $request->input('card_number')) {
            $changes[] = "Card Number: {$oldCardNumber} &rarr; " . $request->input('card_number');
        }
        if ($oldPin !== $request->input('pin')) {
            $changes[] = "PIN Code: {$oldPin} &rarr; " . $request->input('pin');
        }
        if ($oldActivation !== $newActivation) {
            $changes[] = "Activation Date: {$oldActivation} &rarr; {$newActivation}";
        }
        if ($oldExpiration !== $newExpiration) {
            $changes[] = "Expiration Date: {$oldExpiration} &rarr; {$newExpiration}";
        }

        $balanceDiff = $newBalance - $oldBalance;
        if ($balanceDiff !== 0.0) {
            $formattedDiff = ($balanceDiff > 0 ? '+' : '') . number_format($balanceDiff, 2, '.', '') . ' PLN';
            $changes[] = "Balance: {$oldBalance} PLN &rarr; {$newBalance} PLN ({$formattedDiff})";
        }

        if (!empty($changes)) {
            if ($request->input('is_admin') == '1') {
                $title = "Card updated by administrator";
            } else {
                $title = "Card details modified";
            }

            $description = $title . "|" . implode("|", $changes);

            Transaction::create([
                'card_id'     => $card->id,
                'description' => $description,
                'amount'      => $balanceDiff,
                'created_at'  => $polskiCzas,
                'updated_at'  => $polskiCzas,
            ]);
        }

        return redirect('/cards/' . $card->id)->with('success', 'Gift card has been successfully updated!');
    }

    /**
     * Zmiana statusu blokady karty (Aktywna / Zablokowana)
     */
    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $polskiCzas = Carbon::now('Europe/Warsaw')->format('Y-m-d H:i:s');
        
        $card->is_active = !$card->is_active;
        $card->updated_at = $polskiCzas;
        $card->save();

        $statusMessage = $card->is_active ? 'unblocked' : 'blocked';

        Transaction::create([
            'card_id'     => $card->id,
            'description' => 'Card ' . $statusMessage . ' by administrator',
            'amount'      => 0,
            'created_at'  => $polskiCzas,
            'updated_at'  => $polskiCzas,
        ]);

        return redirect('/dashboard')->with('success', "Gift card status has been changed to {$statusMessage}!");
    }

    /**
     * Podgląd szczegółów karty oraz osi czasu
     */
    public function show($id)
    {
        $card = Card::findOrFail($id);
        $transactions = Transaction::where('card_id', $id)->orderBy('created_at', 'desc')->get();
        
        return view('show', compact('card', 'transactions'));
    }

    /**
     * Trwałe usuwanie karty z systemu wraz z automatycznym wyczyszczeniem historii
     */
    public function forceDelete($id)
    {
        $card = Card::findOrFail($id);
        
        Transaction::where('card_id', $id)->delete();
        $card->delete();

        return redirect('/dashboard')->with('success', 'Gift card and its entire transaction history have been permanently removed.');
    }
}