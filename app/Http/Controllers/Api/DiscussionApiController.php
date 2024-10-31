<?php

namespace App\Http\Controllers\Api;

use Pusher\Pusher;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DiscussionRequest;
use App\Http\Resources\Api\Discussion\DiscussionResource;
use App\Http\Resources\Api\Discussion\DiscussionSuggestionResource;
use App\Models\Discussion;
use App\Models\DiscussionSuggestion;
use App\Models\DiscussionComment;
use App\Repositories\DiscussionRepository;
use App\Repositories\DiscussionSuggestionRepository;
use App\Services\Content\Api\DiscussionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscussionApiController extends Controller{
    public function __construct
    (
        private DiscussionService $discussionService,
        private DiscussionRepository $discussionRepository,
        private DiscussionSuggestionRepository $discussionSuggestionRepository
    )
    {
    }

    public function getDiscussion(DiscussionRequest $request)
    {
        try {
            $params = $request->validated();

            $discussions = $this->discussionService->setParams($params)->getContents();

            return $this->sendResponse($discussions,'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function getArchiveDiscussion(DiscussionRequest $request)
    {
        try {
            $params = $request->validated();
            $params['archive'] = true;

            $discussions = $this->discussionService->setParams($params)->getContents();

            return $this->sendResponse($discussions,'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function getArchiveDiscussionDetail($slug)
    {
        $dateNow = Carbon::now('Asia/Jakarta');
        try {
            $discussion = $this->discussionRepository->where(function($q) use ($dateNow){
                $q->whereStatus('archive')
                ->orWhere(function($q2) use ($dateNow){
                    $q2->whereStatus('publish')->whereDate('publish_date_end', '<=', $dateNow);
                });
            })
            ->with('comments','moderator:id,name,image','co_moderator:id,name,image')->whereSlug($slug)->first();

            if (empty($discussion)) {
                return $this->sendResponse($discussion,'Success get data.');
            }

            return $this->sendResponse(new DiscussionResource($discussion),'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function getDiscussionDetail($slug)
    {
        try {
            $discussion = $this->discussionRepository->whereStatus('publish')->with('comments','moderator:id,name,image','co_moderator:id,name,image')->whereSlug($slug)->first();

            if (empty($discussion)) {
                return $this->sendResponse($discussion,'Success get data.');
            }

            // $params['detail'] = $discussion->id;
            // $params['sort_popular'] = 1;
            // $discussion->popular = $this->discussionService->setParams($params)->getCollections();
            // $params['sort_popular'] = 0;
            // $discussion->new = $this->discussionService->setParams($params)->getCollections();

            return $this->sendResponse(new DiscussionResource($discussion),'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function getDiscussionSuggestion(DiscussionRequest $request)
    {
        try {
            $params = $request->validated();

            if (@auth('sanctum')->user()->id) {
                $baseQuery = $this->discussionSuggestionRepository->where('user_id',auth('sanctum')->user()->id);
            } else {
                $baseQuery = $this->discussionSuggestionRepository;
            }


            if (isset($params['keyword'])) {
                $baseQuery = $baseQuery->where('topic','like','%'.$params["keyword"].'%')->orWhere('abstract','like','%'.$params["keyword"].'%');
            }
            $discussionSuggestion = $baseQuery->paginate(5);
            $discussionSuggestion->getCollection()->transform(fn($discussion) => new DiscussionSuggestionResource($discussion));

            return $this->sendResponse($discussionSuggestion,'Success get data.');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function storeDiscussionSuggestion(Request $request)
    {
        DB::beginTransaction();
        try {
            if (auth('sanctum')->user()) {
                $input = $request->all();
                $input['user_id'] = auth('sanctum')->user()->id;
                $input['status'] = 'not_processed';
                $discussionSuggestion = $this->discussionSuggestionRepository->create($input);
                DB::commit();
                return $this->sendResponse($discussionSuggestion,'Success store data.');
            } else {
                return $this->sendError('User not log in.',403);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Failed to store data.',500);
        }
    }

    public function likeDiscussion($id)
    {
        DB::beginTransaction();
        try {
            $discussion = Discussion::whereId($id)->increment('likes');

            DB::commit();

            return $this->sendResponse($discussion,'Success get data.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Failed to get data.',500);
        }
    }

    public function read($slug)
    {
        DB::beginTransaction();
        try {
            $discussion = Discussion::whereSlug($slug)->increment('reads');

            if ($discussion) {
                DB::commit();

                return $this->sendResponse($discussion,'Success read.');
            } else {
                DB::rollBack();

                return $this->sendResponse($discussion,'Failed to read.');
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError('Failed to get data.',500);
        }
    }
}

