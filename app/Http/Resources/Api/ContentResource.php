<?php

namespace App\Http\Resources\Api;

use App\Enums\ContentTypes;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'tags' => ContentTagsResource::collection($this->tags->sortBy('category_id')),
            'location' => new ContentLocationResource($this->location,$this->location_type),
            'video_url' => $this->when($this->page_type_id === ContentTypes::VIDEO->value,$this->video),
            'reads' => (int)$this->reads,
            'likes' => (int)$this->likes,
            'comments' => $this->whenLoaded('comments',
                fn () => new ContentCommentPaginatedResource($this->comments()->whereNull('parent_id')->paginate(5))
            ),
            'similar_contents' => $this->when($request->is('api/content/*'), function ()
            {
                $contents = ($this->resource->newQuery()->whereNot('id',$this->id)
                ->where(['page_type_id' => $this->page_type_id,'status' => 'publish'])
                ->when(session('region') != null, function($q) {
                    return $q->where('location_id',$this->location->id)->where('location_type', $this->location_type);
                })
                // ->where('publish_date','>',$this->publish_date)
                ->where('publish_date','<',Carbon::now())
                ->orderBy('reads','desc')
                ->paginate(4));

                return [
                    'data' => SimilarContentResource::collection($contents->getCollection()),
                    'next_page_url' => $contents->nextPageUrl() ? url('api/similar').'/'.$this->slug.'?page='.($contents->currentPage() + 1) : null
                ];
            }
            ),
            'total_comments' => $this->total_comments,
            'medias' => $this->when(in_array($this->page_type_id,ContentTypes::mediaContents()),$this->medias()->select(['id','content_id','image','documented_by','summary'])->get()),
        ];
    }
}
