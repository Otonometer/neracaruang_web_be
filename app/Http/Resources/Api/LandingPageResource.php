<?php

namespace App\Http\Resources\Api;

use App\Enums\ContentTypes;
use App\Enums\LocationTypes;
use App\Http\Resources\Api\Discussion\DiscussionResource;
use App\Models\Ad;
use App\Models\City;
use App\Models\Content;
use App\Models\Discussion;
use App\Models\Province;
use App\Traits\LocationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LandingPageResource extends JsonResource
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
                            ->whereDate('date_end', '>=', $dateNow);
                    });

        return [
            'location' => $this->when($request->city || $request->province,
                new ContentLocationResource($location,$this->locationType->value)
            ),
            'contents' => [
                'kabar' => ContentResource::collection(
                                $this->resource[ContentTypes::KABAR->value]
                                ->take(3)
                                ->get()
                            ),
                'jurnal' => ContentResource::collection(
                                $this->resource[ContentTypes::JURNAL->value]
                                ->take(empty(request()->all()) ? 2 : 3)
                                ->get()
                            ),
                'video' => ContentResource::collection(
                                $this->resource[ContentTypes::VIDEO->value]
                                ->take(3)
                                ->get()
                                ),
                'info_grafis' => ContentResource::collection(
                                $this->resource[ContentTypes::INFOGRAFIS->value]
                                ->take(2)
                                ->get()
                                ),
                'album_foto' => ContentResource::collection(
                                $this->resource[ContentTypes::ALBUMFOTO->value]
                                ->take(3)
                                ->get()
                            ),
            ],
            'diskusi' => $this->when(!$request->city && !$request->province, DiscussionResource::collection(
                            $request->has('keyword') ?
                            Discussion::where(['status' => 'publish'])
                            ->where('title','like',"%{$request->keyword}%")
                            ->take(2)
                            ->get() :
                            Discussion::where(['status' => 'publish'])
                            ->take(2)
                            ->get()
                        )),
            'ads' => $ads->get(),
            'filter_by_location' => $this->locationType !== LocationTypes::NATIONAL
        ];
    }
}
