<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        try {
            $aboutUs = AboutUs::with(['teams', 'partners'])->first();

            if (!$aboutUs) {
                return response()->json(['message' => 'About Us not found'], 404);
            }

            return response()->json([
                'description' => $aboutUs->description,
                'email' => $aboutUs->email,
                'teams' => $aboutUs->teams,
                'partners' => $aboutUs->partners,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch About Us', 'message' => $e->getMessage()], 500);
        }
    }
}
