<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsAPIController extends Controller
{
    public function getAds($slug)
    {
        $data = Ad::where('location_type', $slug)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully',
            'data' => $data
        ], 200);
    }
}
