<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PoneyController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\FactureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/accueil');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/accueil', function () {
    return view('accueil');
});

Route::resource('poneys', PoneyController::class);

Route::resource('clients', ClientController::class);

//Route::resource('rendez-vous', RendezVousController::class);
Route::resource('rendez-vous', RendezVousController::class)->parameters([
    'rendez-vous' => 'rendezVous'
]);


Route::resource('factures', FactureController::class);

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes réservées aux administrateurs
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'role:client'])->group(function () {
    // Routes réservées aux clients
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    });
});

require __DIR__.'/auth.php';
