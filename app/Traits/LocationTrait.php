<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enums\LocationTypes;
use App\Models\City;
use App\Models\Province;

trait LocationTrait
{
    private LocationTypes $locationType;

    private ?string $location = null;

    private function detertmineLocation(Request $request) :self
    {
        if($request->city && $request->city !== 'indonesia'){
            $this->locationType = LocationTypes::CITY;
            $this->location ??= str_replace('-',' ',$request->city);

            return $this;
        }

        if($request->province){
            $this->locationType = LocationTypes::PROVINCE;
            $this->location ??= str_replace('-',' ',$request->province);

            return $this;
        }

        $this->locationType = LocationTypes::NATIONAL;
        $this->location ??= 'indonesia';

        return $this;
    }

    private function getLocation()
    {
        return $this->locationType !== LocationTypes::PROVINCE
            ? City::where('city_name','LIKE', $this->location)->first()
            : Province::where('province_name','LIKE', $this->location)->first();
    }

}
