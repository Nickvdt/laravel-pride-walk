<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsArticleResource;
use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
    public function index()
    {
        return NewsArticleResource::collection(
            NewsArticle::where('is_active', true)->orderBy('date', 'desc')->get()
        );
    }

    public function show($id)
    {
        $article = NewsArticle::where('is_active', true)->findOrFail($id);
        return new NewsArticleResource($article);
    }
}
