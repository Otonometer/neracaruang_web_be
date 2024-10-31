<?php

namespace App\Models;

use Eloquent as Model;
use App\Enums\SubjectTypes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @SWG\Definition(
 *      definition="Tag",
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
 *      )
 * )
 */

/**
 * @property string $category_name
 * @property int $category_id
 */
class Tag extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'tags';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $appends = [
        'category_name'
    ];


    public $fillable = [
        'title',
        'slug',
        'icon',
        'category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'icon' => 'string',
        'slug' => 'string'
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

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function categoryName() :Attribute
    {
        return Attribute::make(
            get: fn () :string => SubjectTypes::tryFrom($this->category_id)->title()
        );
    }

    public function icon()
    {
        return $this->morphMany(Icon::class, 'iconnable');
    }

    public function blue()
    {
        return $this->icon()->where('color', 'blue')->first();
    }

    public function green()
    {
        return $this->icon()->where('color', 'green')->first();
    }
}
