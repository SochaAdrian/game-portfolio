<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('games.index');
    }

    return redirect()->route('login');
})->name('welcome');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
    ->name('login');

Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/game/choose-character', [GameController::class, 'index'])->name('games.index');

    Route::get('/game/create-character', [GameController::class, 'createCharacter'])->name('games.create-character');

    Route::get('/game/choose-character/{character}', [GameController::class, 'chooseCharacter'])
        ->whereNumber('character')
        ->name('games.choose-character');

    Route::get('/game/camp', [GameController::class, 'camp'])->name('games.camp');

    Route::get('/game/map', [GameController::class, 'map'])->name('games.map');

    Route::get('/game/quests', [GameController::class, 'quests'])->name('games.quests');

    Route::get('/game/buildings', [GameController::class, 'buildings'])->name('games.buildings');

    Route::get('/game/quests/participate/', [GameController::class, 'participateInQuest'])->name('games.participate');

    Route::get('/game/quests/participate/{quest}',
        [GameController::class, 'participateInParticularQuest'])->name('games.participate.id');


    Route::get('/game/game-screen', function () {
        return Inertia::render('game/dashboard');
    })->name('games.game-screen');
});

