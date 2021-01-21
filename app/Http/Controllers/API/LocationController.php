<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function provinces(Request $request)
    {
        return Province::all();
    }

    public function regencies(Request $request, $provincies_id) 
    {
        return Regency::where('province_id', $provincies_id)->get();
    }
}
