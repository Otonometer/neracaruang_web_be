<?php

namespace App\Http\Resources\Api;

use App\Traits\LocationTrait;
use App\Enums\LocationTypes;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentTagsResource extends JsonResource
{
    use LocationTrait;
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
            'image' => (session('region') != null && $this->locationType !== LocationTypes::NATIONAL) || session('region') === true
                ? $this->green()?->image
                : $this->blue()?->image,
            'slug' => $this->slug,
            'title' => $this->title,
            'subject' => $this->category_name
        ];
    }
}
