<?php

namespace App\Http\Resources\Api\Discussion;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionSuggestionResource extends JsonResource
{
    private $statuses = [
        'not_processed' => 'Not Processed',
        'processing' => 'Processing',
        'accepted' => 'Accepted',
        'cancel' => 'Cancelled',
    ];

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'abstract' => $this->abstract,
            'user' => [
                'name' => $this->user->name,
                'image' => $this->user->image,
            ],
            'status' => $this->statuses[$this->status],
            'created_at' => Carbon::parse($this->created_at)->setTimezone('Asia/Jakarta')->format('d/m/y'),
        ];
    }
}
