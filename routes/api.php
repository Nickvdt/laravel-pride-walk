<?php

use App\Http\Controllers\Api\ExhibitionController;
use App\Http\Controllers\Api\NewsArticleController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsRibbonController;


Route::get('/exhibitions', [ExhibitionController::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show']);

Route::get('/exhibitions-upcoming', [ExhibitionController::class, 'upcoming']);

Route::get('/news', [NewsArticleController::class, 'index']);
Route::get('/news/{id}', [NewsArticleController::class, 'show']);

Route::get('/news-ribbon', [NewsRibbonController::class, 'getActive']);


Route::group(['prefix' => 'tags'], function () {
    Route::get('/', [TagController::class, 'index']);
    Route::get('/filter', [TagController::class, 'filter']);
});
