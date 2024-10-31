<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationApiController extends Controller{
    public function getProvince() {
        try {
            $provinces = Province::select('id','province_name','slug')->get();
            return $this->sendResponse($provinces,'Success get data.');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function getCityByProvince($province_id = null) {
        try {
            $city = City::select('id','city_name','slug');

            if ($province_id) {
                $keyword = str_replace('-',' ', $province_id);
                $province = Province::where('province_name','like','%'.$keyword.'%')->first();
                $city = $city->where('province_code', $province->id);
                // $city = $city->where('province_code', $province_id);
            }
            $city = $city->get();
            return $this->sendResponse($city,'Success get data.');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->sendError('Failed to get data.',500);
        }
    }
}
