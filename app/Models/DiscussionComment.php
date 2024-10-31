<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscussionComment extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'discussion_comments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $appends = ['is_liked'];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'discussion_id',
        'parent_id',
        'reply_to',
        'comments',
        'user_id',
        'likes'
    ];

    public function replies()
    {
        return $this->hasMany($this::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo($this::class, 'id','parent_id');
    }

    public function reply()
    {
        return $this->belongsTo($this::class,'reply_to','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLiked() : Attribute
    {
        return Attribute::make(
            get: fn () => !empty($this->likes()->where('user_id', auth('sanctum')->user()->id ?? false)->first())
        );
    }
}
