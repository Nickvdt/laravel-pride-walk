<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExhibitionResource;
use App\Library\Tags\ApplyTags;
use App\Models\Exhibition;
use Illuminate\Http\Request;


class ExhibitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Exhibition::with([
            'schedules' => function ($query) {
                $query->orderBy('date')->orderBy('start_time');
            },
            'tags'
        ])->where('is_active', true);

        $tags = $request->input('tags');
        
        if($tags) {
            $query = ApplyTags::apply($query, $tags);
        }
        
        return ExhibitionResource::collection(
            $query->get()
        );
    }

    public function show($id)
    {
        $exhibition = Exhibition::with([
            'schedules' => function ($query) {
                $query->orderBy('date')->orderBy('start_time');
            },
            'tags'
        ])->findOrFail($id);

        return new ExhibitionResource($exhibition);
    }
}
