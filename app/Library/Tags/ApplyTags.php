<?php

namespace App\Library\Tags;

class ApplyTags
{
    public static function apply($query, $tagIds)
    {
        return $query->whereHas('tags', function ($query) use ($tagIds) {
            $query->whereIn('id', $tagIds);
        });
    }
}