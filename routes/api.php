<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCharacterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    //User routes

    //Characters routes
    Route::post('/characters', [UserCharacterController::class, 'store'])->name('characters.store');
    Route::get('/characters', [UserCharacterController::class, 'index'])->name('characters.index');
    Route::get('/character/resources', [UserCharacterController::class, 'getResources'])->name('characters.resources');


    //Quests routes
    Route::post('/quests/{id}/start', [GameController::class, 'startQuest'])->name('quests.start');
    Route::post('/quests/{id}/finish', [GameController::class, 'finishQuest'])->name('games.completeQuest');
    //Items routes

    //Statistic routes

    //Building routes
    Route::post('/buildings/{building}/build', [GameController::class, 'buildBuilding'])->name('buildings.build');

    //Localization routes
    Route::get('/localization/{id}', [GameController::class, 'changeLocalization'])->name('change.localization');
    Route::get('/localization/{id}/npc', [GameController::class, 'getNpcs'])->name('localization.npc.index');
    Route::get('/npc/{npcId}/talk', [GameController::class, 'talkToNpc'])->name('localization.npc.talk');
    //Resources routes
    Route::post('/resources/{id}/increment', [ResourcesController::class, 'increment'])->name('resources.increment');
});

