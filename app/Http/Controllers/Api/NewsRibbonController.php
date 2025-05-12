<?php

namespace App\Http\Controllers\Api;

use App\Models\NewsRibbon;
use App\Http\Controllers\Controller;

class NewsRibbonController extends Controller
{
    public function getActive()
    {
        $newsRibbon = NewsRibbon::where('active', true)->first();

        return response()->json($newsRibbon ?: null);
    }
}
