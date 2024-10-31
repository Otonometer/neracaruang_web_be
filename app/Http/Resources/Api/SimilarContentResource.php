<?php

namespace App\Http\Resources\Api;

use App\Enums\ContentTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SimilarContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content_body' => $this->content,
            'image' => $this->image,
            'publish_date' => Carbon::parse($this->publish_date)->setTimezone('Asia/Jakarta')->format('d/m/y, H:i T'),
            'writer' => new ContentWriterResource($this->writer),
            'tags' => ContentTagsResource::collection($this->tags),
            'location' => new ContentLocationResource($this->location,$this->location_type),
            'reads' => (int)$this->reads,
            'likes' => (int)$this->likes,
            'total_comments' => $this->total_comments,
            'medias' => $this->when(in_array($this->page_type_id,ContentTypes::mediaContents()),$this->medias()->select(['id','content_id','image','summary'])->get()),
        ];
    }
}
