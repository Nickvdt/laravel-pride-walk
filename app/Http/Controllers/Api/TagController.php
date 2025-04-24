<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function filter(Request $request)
    {
        $tagName = $request->input('tag');
        $type = $request->input('type');

        $query = Tag::query();

        if ($tagName) {
            $query->where('name', $tagName);
        }

        $tags = $query->get();

        $results = [];

        foreach ($tags as $tag) {
            if ($type === 'App\Models\Exhibition') {
                $results[] = [
                    'tag' => $tag->name,
                    'exhibitions' => $tag->exhibitions,
                ];
            } elseif ($type === 'App\Models\NewsArticle') {
                $results[] = [
                    'tag' => $tag->name,
                    'news_articles' => $tag->newsArticles,
                ];
            } else {
                $results[] = [
                    'tag' => $tag->name,
                    'exhibitions' => $tag->exhibitions,
                    'news_articles' => $tag->newsArticles,
                ];
            }
        }

        return response()->json($results);
    }
}
