<?php

namespace App\Http\Resources\Api\Discussion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscussionCommentResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => DiscussionCommentReplyResource::collection($this->collection),
            'link' => $this->nextPageUrl() ? url('api/discussion-comment-paginate').'/'.$this->collection[0]->discussion_id.'?page='.($this->currentPage() + 1) : null
        ];
    }
}
