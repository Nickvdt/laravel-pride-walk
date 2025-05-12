<?php

namespace App\Http\Controllers\Api;

use App\Models\NewsRibbon;
use App\Http\Controllers\Controller;

class NewsRibbonController extends Controller
{
    // Fetch the active NewsRibbon
    public function getActive()
    {
        $newsRibbon = NewsRibbon::where('active', true)->first();

        if (!$newsRibbon) {
            return response()->json(['message' => 'No active NewsRibbon found'], 404);
        }

        return response()->json($newsRibbon);
    }
}
