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

            // Haal alleen de bestandsnaam op
            $image = $aboutUs->image ? basename($aboutUs->image) : null;

            return response()->json([
                'description' => $aboutUs->description,
                'email' => $aboutUs->email,
                'image' => $image,  // Alleen de bestandsnaam
                'teams' => $aboutUs->teams,
                'partners' => $aboutUs->partners,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch About Us', 'message' => $e->getMessage()], 500);
        }
    }
}
