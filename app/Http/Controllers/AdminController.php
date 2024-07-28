<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\YouthProfile;
use App\Http\Resources\YouthProfileResource;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {
        $youthprofiles = YouthProfile::with('demographic')->get();

        return Inertia::render('Admin/AdminIndex', [
            'youthprofiles' => YouthProfileResource::collection($youthprofiles)
        ]);
    }
}

