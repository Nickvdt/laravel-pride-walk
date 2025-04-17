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
        return ExhibitionResource::collection(
            Exhibition::with(['schedules' => function ($query) {
                $query->orderBy('date')->orderBy('start_time');
            }])->where('is_active', true)->get()
        );
    }

    public function show($id)
    {
        $exhibition = Exhibition::with(['schedules' => function ($query) {
            $query->orderBy('date')->orderBy('start_time');
        }])->findOrFail($id);

        return new ExhibitionResource($exhibition);
    }
}
