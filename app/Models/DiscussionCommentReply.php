<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionCommentReply extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'discussion_comment_replies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'comment_id',
        'reply_id',
        'comments',
        'user_id',
        'likes'
    ];
}
