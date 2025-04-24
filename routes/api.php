<?php

use App\Http\Controllers\Api\ExhibitionController;
use App\Http\Controllers\Api\NewsArticleController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/exhibitions', [ExhibitionController::class, 'index']);
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show']);

Route::get('/news', [NewsArticleController::class, 'index']);
Route::get('/news/{id}', [NewsArticleController::class, 'show']);

<<<<<<< HEAD
Route::get('/tags', [TagController::class, 'index']);
=======
Route::get('/tags', [TagController::class, 'filter']);
>>>>>>> d07bd080818fef6a89e6ee6b6eb246e6357229c1
