<?php

namespace App\Http\Resources\Api\Discussion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionCommentReplyResource extends JsonResource
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
            'discussion_id' => $this->discussion_id,
            'likes' => $this->likes,
            'comments' => $this->comments,
            'user' => [
                'name' => $this->user->name,
                'image' => $this->user->image,
            ],
            'is_liked' => $this->is_liked,
            'reply_to' => $this->whenLoaded('reply', new DiscussionCommentReplyResource($this->reply)),
        ];
    }
}
