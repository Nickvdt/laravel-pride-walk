<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExhibitionResource;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
    public function index()
    {
        return ExhibitionResource::collection(Exhibition::where('is_active', true)->get());
    }

    public function show($id)
    {
        $exhibition = Exhibition::findOrFail($id);
        return new ExhibitionResource($exhibition);
    }
}
