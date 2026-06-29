<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Dołączenie tras uwierzytelniania Breeze (login, register itp.)
require __DIR__.'/auth.php';

// TRASA RATUNKOWA: Pozwala na bezproblemowe wylogowanie przez wpisanie /logout w przeglądarce
Route::get('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// Automatyczne przechwycenie pustego adresu z Breeze i przekierowanie na Twój panel kart
Route::redirect('/dashboard', '/');

// =========================================================================
// ZABEZPIECZONA STREFA PANELU KART (Dostępna wyłącznie po zalogowaniu)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    // Twój oryginalny dashboard na stronie głównej
    Route::get('/', [CardController::class, 'index'])->name('dashboard');

    // Trasy zasobów dla kart podpięte pod odpowiednie metody kontrolera
    Route::get('/cards/create', [CardController::class, 'create']);
    Route::post('/cards', [CardController::class, 'store']);
    Route::get('/cards/{id}', [CardController::class, 'show']);
    Route::get('/cards/{id}/edit', [CardController::class, 'edit']);
    Route::put('/cards/{id}', [CardController::class, 'update']);
    Route::delete('/cards/{id}', [CardController::class, 'destroy']); // Blokowanie/odblokowanie karty

    // Bezpieczne, trwałe usuwanie powiązań bazy danych
    Route::delete('/cards/{id}/force', [CardController::class, 'forceDelete']);
});