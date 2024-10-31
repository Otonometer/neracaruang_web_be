<?php

namespace App\Http\Controllers\Api;

use App\Enums\LocationTypes;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialMediaController extends Controller{
    public function getSocialMedia(Request $request) {
        try {
            if (isset($request->param) && $request->param == 'hijau') {
                $socials = SocialMedia::select('title','url','image_green as image')->get();
                $location = true;
                $data['socials'] = $socials;
                $data['location'] = $location;
            } else {
                $socials = SocialMedia::select('title','url','image')->get();
                $location = false;
                $data['socials'] = $socials;
                $data['location'] = $location;
            }
            return $this->sendResponse($data,'Success get data.');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Failed to get data.',500);
        }
    }
}
