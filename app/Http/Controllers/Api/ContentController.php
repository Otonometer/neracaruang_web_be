<?php

namespace App\Http\Controllers\Api;

use App\Models\Ad;
use Carbon\Carbon;
use App\Models\Content;
use App\Enums\ContentTypes;
use App\Models\TagsContent;
use Illuminate\Http\Request;
use App\Models\ContentComment;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use App\Repositories\ContentRepository;
use App\Http\Resources\Api\ContentResource;
use App\Http\Resources\Api\ContentsResource;
use App\Services\Content\Api\ContentService;
use App\Http\Requests\Api\FilterContentRequest;
use App\Http\Resources\Api\LandingPageResource;
use App\Http\Resources\Api\SimilarContentResource;
use App\Http\Resources\Api\RepliesCommentContentResource;
use App\Http\Resources\Api\ContentCommentPaginatedResource;
use App\Http\Resources\Api\ContentLocationResource;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use App\Traits\LocationTrait;
use App\Enums\LocationTypes;

class ContentController extends Controller
{
    use LocationTrait;

    public function __construct
    (
        private ContentService $contentService,
        private ContentRepository $contentRepository,
        private CityRepository $cityRepository
    )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(FilterContentRequest $request)
    {
        $params = $request->validated();

        $contents = $this->contentService->setParams($params)->getContents();

        return response()->json($contents);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, $location = null)
    {
        
        $content = $this->contentRepository->where(['slug' => $slug,'status' => 'publish'])->with(['tags','writer','comments','comments.replies','comments.replies.replies'])->first();

        $dateNow = Carbon::now();

        if (!$content) {
            return response()->json(['message' => 'Content not Found'],404);
        }

        $ads = Ad::where(['location_type' => LocationTypes::NATIONAL->value]);

        if($content->location_type === LocationTypes::PROVINCE){
            $ads = Ad::where(['location_type' => LocationTypes::PROVINCE->value,'location_id' => $content?->location_id]);
        }else{
            $ads = Ad::where(['location_type' => LocationTypes::CITY->value,'location_id' => $content?->location_id])
                ->orWhere(function($q) use($content) {
                    $q->where(['location_type' => LocationTypes::PROVINCE->value, 'location_id' => $content?->location->province_code]);
                });
        }

        $ads->where(['status' => 'publish',
                    ])->where(function($q) use ($dateNow) {
                        $q->whereDate('date_start', '<=', $dateNow)
                            ->whereDate('date_end', '>=', $dateNow);
                    });


        $data = [
            'content' => new ContentResource($content),
            'ads' => $ads->get(),
            'meta_keyword' => $this->contentService->getMetaKeyword($content)
        ];

        if ($location && $content->location->city_name !== 'INDONESIA') {
            session(['region' => true]);
            if (@$data['content']['location_type'] == 'province') {
                $location = Province::where('province_name',str_replace('-',' ',$data['content']->resource->location->province_name))->first();
                $type = 'province';
            } else {
                $location = City::where('city_name',str_replace('-',' ',$data['content']->resource->location->city_name))->first();
                $type = 'city';
                if ($data['content']->resource->location->city_name != 'INDONESIA') {
                    $type = 'national';
                }
            }
            $data['content'] = new ContentResource($content);
            $data['location'] = [
                'id' => $location->id,
                'name' => $location->city_name ?? $location?->province_name,
                'image' => $location->green()?->image,
                'slug' => $location->slug,
                'type' => $type
            ];
        } else {
            session(['region' => null]);
        }

        return response()->json($data);
    }

    public function getComment(string $slug)
    {
        $content = $this->contentRepository->select(['id','slug'])->where(['slug' => $slug])->first();

        return response()->json([
            'comments' => new ContentCommentPaginatedResource($content->comments()->whereNull('parent_id')->paginate(5))
        ]);
    }

    public function getReplies(int $parentId)
    {
        $replies = ContentComment::where(['parent_id' => $parentId])->paginate(2);

        return response()->json([
            'replies' => $replies->getCollection()->transform(fn($reply) => new RepliesCommentContentResource($reply)),
            'next_page_url' => $replies->nextPageUrl()
        ]);
    }

    public function getSimilarContent(string $slug)
    {
        $content = $this->contentRepository->where('slug',$slug)->first();
        $similarContents = $this->contentRepository->whereNot('slug',$slug)
                            ->where('page_type_id', $content->page_type_id)
                            // ->where('publish_date','>',$content->publish_date)
                            ->where('publish_date','<',Carbon::now())
                            ->orderBy('reads','desc')
                            ->offset(2)
                            ->paginate(2);

        if ($similarContents->currentPage() >= 4) {
            $nextPage = null;
        } else {
            $nextPage = $similarContents->nextPageUrl()
            ? url('api/similar').'/'.$slug.'?page='.($similarContents->currentPage() + 1) : null;
        }

        return response()->json([
            'data' => SimilarContentResource::collection($similarContents->getCollection()),
            'next_page_url' => $nextPage
        ]);
    }

    public function readContent(string $slug)
    {
        $content = $this->contentRepository->where('slug',$slug)->first();

        $content->update([
            'reads' => $content->reads  + 1
        ]);

        return response()->json([
            "message" => 'success'
        ],200);
    }
}
