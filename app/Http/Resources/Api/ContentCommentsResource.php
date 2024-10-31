<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentCommentsResource extends JsonResource
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
            'comment' => $this->comment,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name
            ],
            'likes' => $this->likes,
            'total_repiles' => $this->replies->count(),
            'replies_link' => $this->replies->count() > 0 ? route('api.content.replies-comment',$this->id) : null
        ];
    }
}
