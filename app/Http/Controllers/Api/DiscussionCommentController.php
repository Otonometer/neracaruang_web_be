<?php

namespace App\Http\Controllers\Api;

use Pusher\Pusher;
use Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Discussion\DiscussionCommentResource;
use App\Models\Discussion;
use App\Models\DiscussionComment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscussionCommentController extends Controller{

    public function comment(Request $request, $discussion_id) {
        $return = $this->checkDiscussion($discussion_id);

        if ($return === true) {
            $rules = ['comment' => 'required'];
            $messages = ['comment.required' => 'Please enter message to communicate.'];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $message = implode("", $validator->messages()->all());
                return $this->sendError($message,500);
            }
            DB::beginTransaction();
            try {
                // Create comment
                $user = auth('sanctum')->user();
                $user_id = @$user->id ?? 1;

                $field = [
                    'discussion_id' => @$discussion_id,
                    'comments' => @$request->comment,
                    'user_id' => @$user_id,
                ];

                // $discussionComment = $request->message;
                $discussionComment = DiscussionComment::create($field);
                $discussionComment->user = User::whereId($discussionComment->user_id)->select('id','name','image')->first();

                $response = $this->triggerPusher($discussionComment, $discussion_id);

                if($response){
                    DB::commit();
                    return $this->sendResponse($discussionComment,'Success get data.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError($e->getMessage(),500);
            }
        } else {
            return $return;
        }
    }

    public function reply(Request $request, $discussion_id, $comment_id) {
        $return = $this->checkDiscussion($discussion_id);

        if ($return === true) {
            $rules = ['comment' => 'required'];
            $messages = ['comment.required' => 'Please enter message to communicate.'];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $message = implode("", $validator->messages()->all());
                return $this->sendError($message,500);
            }
            DB::beginTransaction();
            try {
                // Create comment
                $user = auth('sanctum')->user();
                $user_id = @$user->id ?? 1;

                $parent = DiscussionComment::whereId($comment_id)->first();

                $field = [
                    'discussion_id' => @$discussion_id,
                    // 'parent_id' => @$parent ? $parent->parent_id : null,
                    'reply_to' => $comment_id,
                    'comments' => @$request->comment,
                    'user_id' => @$user_id,
                ];

                $discussionComment = DiscussionComment::create($field);
                $comment_reply = DiscussionComment::find($discussionComment->reply_to);
                $discussionComment->user = User::whereId($discussionComment->user_id)->select('id','name','image')->first();
                $discussionComment->reply_to = User::whereId($comment_reply->user_id)->select('id','name','image')->first();

                $response = $this->triggerPusher($discussionComment, $discussion_id);

                if($response){
                    DB::commit();
                    return $this->sendResponse($discussionComment,'Success get data.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->sendError($e->getMessage(),500);
            }
        } else {
            return $return;
        }
    }

    public function commentPaginate($discussion_id)
    {
        $comment = DiscussionComment::where('discussion_id', $discussion_id)->orderBy('created_at','desc')->paginate(5);

        return $this->sendResponse(new DiscussionCommentResource($comment),'Success get data.');
        // return $this->sendResponse($comment, 'Success get comment paginate');
    }

    public function triggerPusher($data, $discussion_id)
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        return $pusher->trigger('chat-channel-'.$discussion_id, 'message-event-'.$discussion_id, ['data' => $data]);
    }

    public function checkDiscussion($discussion_id)
    {
        // Cek discussion
        $discussion = Discussion::find($discussion_id);

        if (empty($discussion)) {
            return $this->sendError('Discussion not found.',404);
        }

        if ($discussion->status == 'archive') {
            return $this->sendError('This is archied discussion.',404);
        }

        return true;
    }
}
