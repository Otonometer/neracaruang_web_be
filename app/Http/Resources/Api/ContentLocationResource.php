<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\LocationTypes;
use App\Traits\LocationTrait;

class ContentLocationResource extends JsonResource
{
    use LocationTrait;

    public function __construct(private $collection, private string $type)
    {
        parent::__construct($collection);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->detertmineLocation($request);

        return [
            'id' => $this->id,
            'name' => $this->city_name ?? $this?->province_name,
            'image' => (session('region') != null && $this->locationType !== LocationTypes::NATIONAL) || session('region') === true
                        ? $this->green()?->image
                        : $this->blue()?->image,
            'slug' => $this->slug,
            'type' => $this->type
        ];
    }
}
