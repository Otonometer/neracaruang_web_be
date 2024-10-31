<?php

namespace App\Models;

use App\User;
use Illuminate\Support\Str;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Discussion",
 *      required={""},
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="slug",
 *          description="slug",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="summary",
 *          description="summary",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="content",
 *          description="content",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      )
 * )
 */
class Discussion extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'discussions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $appends = ['is_liked'];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'reads',
        'likes',
        'moderator',
        'co_moderator',
        'publish_date_start',
        'publish_date_end',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'summary' => 'string',
        'content' => 'string',
        'image' => 'string',
        'status' => 'string'
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

    public function moderator() {
        return $this->hasOne(User::class, 'id', 'moderator');
    }

    public function co_moderator() {
        return $this->hasOne(User::class, 'id', 'co_moderator');
    }

    public function comments()
    {
        return $this->hasMany(DiscussionComment::class,'discussion_id','id')->whereNull('parent_id')->orderBy('created_at','desc');
    }

    public function totalComments() :Attribute
    {
        return Attribute::get(function () :int
        {
            $total = $this->comments()->count();

            return $total;
        });
    }

    public function liked()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLiked() : Attribute
    {
        return Attribute::make(
            get: fn () => !empty($this->liked()->where('user_id', auth('sanctum')->user()->id ?? false)->first())
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $model->slug = Str::slug($model->title);
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
        static::updating(function ($model) {
            try {
                $model->slug = Str::slug($model->title);
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
