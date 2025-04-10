<?php

use App\Http\Controllers\Api\ExhibitionController;
use App\Http\Controllers\Api\NewsArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/exhibitions', [ExhibitionController::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show']);

Route::get('/news', [NewsArticleController::class, 'index']);
Route::get('/news/{id}', [NewsArticleController::class, 'show']);