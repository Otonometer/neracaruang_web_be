<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepliesCommentContentResource extends JsonResource
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
            'reply_to' => [
                'comment_id' => $this->reply_to ?? $this->parent_id,
                'user_name' => $this->reply_to ? $this->repliedTo->user->name : $this->parent->user->name
            ],
            'comment' => $this->comment
        ];
    }
}
