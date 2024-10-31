<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentCommentPaginatedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->resource->getCollection()->transform(fn($comment) => new ContentCommentsResource($comment)),
            'next_page_url' => $this->nextPageUrl() ? $this->path().'/comments?page=2' : null
        ];
    }
}
