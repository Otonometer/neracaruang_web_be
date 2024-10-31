<?php

namespace App\Http\Resources\Api\Discussion;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimilarDiscussionResource extends JsonResource
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
            'content' => $this->content,
            'image' => $this->image,
            'publish_date_start' => Carbon::parse($this->publish_date_start)->setTimezone('Asia/Jakarta')->format('d/m/y'),
            'publish_date_end' => Carbon::parse($this->publish_date_end)->setTimezone('Asia/Jakarta')->format('d/m/y'),
            'moderator' => new DiscussionModeratorResource($this->moderator()->first()),
            'co_moderator' => new DiscussionCoModeratorResource($this->co_moderator()->first()),
            'reads' => $this->reads,
            'likes' => $this->likes,
            'is_liked' => $this->is_liked,
            'comments' => $this->whenLoaded('comments', new DiscussionCommentResource($this->comments()->paginate(5))),
            'total_comments' => $this->total_comments,
            'channel' => 'chat-channel-'.$this->id,
            'event' => 'message-event-'.$this->id,
        ];
    }
}
