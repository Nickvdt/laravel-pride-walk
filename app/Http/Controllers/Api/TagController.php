<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $requiredContentType = $request->requiredContentType;
        $cacheKey = 'tags_index_' . md5($requiredContentType);
        $cacheDuration = 5;

        $tags = Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            $tagsQuery = Tag::query();

            if ($request->has('requiredContentType')) {
                $this->applyRequiredContentType($tagsQuery, $request->input('requiredContentType'));
            }

            return $tagsQuery->get();
        });

        return response()->json($tags);
    }

    public function applyRequiredContentType($tags, $requiredContentType) {
        if($requiredContentType === 'exhibitions') {
            return $tags->whereHas('exhibitions');
        }
        if($requiredContentType === 'news') {
            return $tags->whereHas('newsArticles');
        }
        return $tags;
    }

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
