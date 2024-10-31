<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ContentCommentPaginatedResource;
use App\Models\Content;
use App\Models\ContentComment;
use App\Models\Discussion;
use App\Models\DiscussionComment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class ContentCommentAPIController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = auth('sanctum')->user();
    }

    public function getComment($content_id)
    {
        $user = auth('sanctum')->user();

        $data = ContentComment::where('content_id', $content_id)->whereNull('parent_id')->with(['user:id,name,image','replies','replies.user:id,name,image','replies.reply_to','replies.reply_to.user:id,name,image'])->orderBy('created_at', 'DESC')->paginate(5);

        // return $this->sendResponse(new ContentCommentPaginatedResource($data), 'Data retrieved successfully');
        return $this->sendResponse($data, 'Data retrieved successfully');
    }

    public function postComment($content_id, Request $request)
    {
        DB::beginTransaction();
        try {
            $comment = ContentComment::create([
                'content_id' => $content_id,
                'user_id' => $this->user->id,
                'comment' => $request['comment'],
            ]);

            DB::commit();
            return $this->sendResponse($comment, 'Success post comment');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function replyComment($content_id, $comment_id, Request $request)
    {
        DB::beginTransaction();
        try {
            $parent = ContentComment::whereId($comment_id)->first();

            $comment = ContentComment::create([
                'parent_id' => @$parent->parent_id ?? $comment_id,
                'reply_to' => @$parent->parent_id ? $comment_id : null,
                'content_id' => $content_id,
                'user_id' => $this->user->id,
                'comment' => $request['comment'],
            ]);

            DB::commit();
            return $this->sendResponse($comment, 'Success reply comment');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function like(Request $request)
    {
        DB::beginTransaction();
        try {
            $type = $request->type;
            $id = $request->id;
            $types = null;

            if ($type == 'content') {
                $types = Content::class;
            } elseif ($type == 'discussion') {
                $types = Discussion::class;
            } elseif ($type == 'content_comment') {
                $types = ContentComment::class;
            } else {
                $types = DiscussionComment::class;
            }

            // Check if content exist
            $cek = $types::whereId($id)->first();
            if (empty($cek)) {
                return $this->sendError('Content not found', 404);
            }

            $like = Like::where('user_id', $this->user->id)->where('likeable_type', $types)->where('likeable_id', $id)->first();

            if (empty($like)) {
                Like::create([
                    'user_id' => $this->user->id,
                    'likeable_type' => $types,
                    'likeable_id' => $id
                ]);
                $data = $types::whereId($id)->first();
                $data->likes = $data->likes + 1;

                $data->save();
                $response = [
                    'is_liked' => true
                ];
                $message = 'Success Like.';
            } else {
                $like->forceDelete();
                $data = $types::whereId($id)->first();
                $data->likes = $data->likes - 1;

                $data->save();
                $response = [
                    'is_liked' => false
                ];
                $message = 'Success UnLike.';
            }
            DB::commit();
            return $this->sendResponse($response,$message);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return $this->sendError('Something went wrong.',500);
        }
    }
}
