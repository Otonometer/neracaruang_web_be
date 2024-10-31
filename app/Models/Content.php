<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\DB;
use App\Enums\LocationTypes;

/**
 * @SWG\Definition(
 *      definition="Content",
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
 *          property="video",
 *          description="video",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="location_type",
 *          description="location_type",
 *          type="string"
 *      )
 * )
 */
class Content extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $connection = 'mysql';
    public $table = 'contents';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'video',
        'page_type_id',
        'image',
        'location_id',
        'location_type',
        'created_by',
        'reads',
        'likes',
        'publish_date',
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
        'video' => 'string',
        'image' => 'string',
        'location_type' => 'string'
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

    public function tags()
    {
        return $this->hasManyThrough(Tag::class, TagsContent::class, 'content_id', 'id', 'id', 'tag_id');
    }

    public function medias()
    {
        return $this->hasMany(ContentMedia::class,'content_id','id');
    }


    public function writer()
    {
        return $this->belongsTo(Writer::class,'created_by','id');
    }

    public function comments()
    {
        return $this->hasMany(ContentComment::class,'content_id','id');
    }

    public function repliedComments()
    {
        return $this->hasManyThrough(ContentCommentReply::class,ContentComment::class, 'content_id','id','id','content_id');
    }

    public function totalComments() :Attribute
    {
        return Attribute::get(function () :int
        {
            return $this->comments()->count();
        });
    }

    public function location()
    {
        if($this->location_type === LocationTypes::PROVINCE->value){
            return $this->belongsTo(Province::class,'location_id','id');
        }

        return $this->belongsTo(City::class,'location_id','id');
    }
}
