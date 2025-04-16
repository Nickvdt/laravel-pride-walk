<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExhibitionScheduleController;


Route::get('/', function () {
    return redirect()->route('filament.admin.pages.dashboard'); 
});


Route::post('/exhibitions/{exhibition}/schedules', [ExhibitionScheduleController::class, 'store']);
Route::put('/schedules/{schedule}', [ExhibitionScheduleController::class, 'update']);
Route::delete('/schedules/{schedule}', [ExhibitionScheduleController::class, 'destroy']);