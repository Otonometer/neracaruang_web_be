<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @SWG\Definition(
 *      definition="ContentComment",
 *      required={""},
 *      @SWG\Property(
 *          property="comment",
 *          description="comment",
 *          type="string"
 *      )
 * )
 */
class ContentComment extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'content_comments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $appends = ['is_liked'];

    protected $dates = ['deleted_at'];


    public $fillable = [
        'parent_id',
        'reply_to',
        'content_id',
        'user_id',
        'comment',
        'likes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'comment' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

    }

    public function replies()
    {
        return $this->hasMany($this::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reply_to()
    {
        return $this->belongsTo($this::class,'reply_to','id');
    }

    public function parent()
    {
        return $this->belongsTo($this::class,'parent_id','id');
    }

    public function isLiked() : Attribute
    {
        return Attribute::make(
            get: fn () => !empty($this->likes()->where('user_id', auth('sanctum')->user()->id ?? false)->first())
        );
    }

}
