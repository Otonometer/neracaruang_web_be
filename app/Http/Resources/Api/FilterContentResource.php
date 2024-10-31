<?php

namespace App\Http\Resources\Api;

use App\Enums\LocationTypes;
use App\Enums\ContentTypes;
use App\Models\Ad;
use App\Models\City;
use App\Models\Meta;
use App\Models\Province;
use App\Traits\LocationTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class FilterContentResource extends JsonResource
{
    use LocationTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dateNow = Carbon::now('Asia/Jakarta');
        $location = $this->detertmineLocation($request)->getLocation();


        $ads = Ad::where(['location_type' => LocationTypes::NATIONAL->value]);

        if($this->locationType === LocationTypes::PROVINCE){
            $ads = Ad::where(['location_type' => LocationTypes::PROVINCE->value,'location_id' => $location?->id]);
        }else if($this->locationType === LocationTypes::CITY){
            $ads = Ad::where(['location_type' => LocationTypes::CITY->value,'location_id' => $location?->id])
                ->orWhere(function($q) use($location) {
                    $q->where(['location_type' => LocationTypes::PROVINCE->value, 'location_id' => $location?->province_code]);
                });
        }

        $ads->where(['status' => 'publish',
                    ])->where(function($q) use ($dateNow) {
                        $q->whereDate('date_start', '<=', $dateNow)
                            ->orWhereDate('date_end', '>=', $dateNow);
                    });

        $iklan = $ads->get();

        return [
            'location' => $this->when(session('region') != null,
                new ContentLocationResource($location,$this->locationType->value)
            ),
            'contents' => $this->resource,
            'filter_by_location' => $this->locationType !== LocationTypes::NATIONAL,
            'ads' => $ads->get(),
            'meta' => $this->when($request->type,Meta::where('page_id',ContentTypes::getValueFromSlug($request->type))->first()?->only(['title','description','keyword']))
        ];
    }
}
