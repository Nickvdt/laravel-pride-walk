<?php

use App\Http\Controllers\Api\ExhibitionController;
use Illuminate\Support\Facades\Route;

Route::get('/exhibitions', [ExhibitionController::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show']);
