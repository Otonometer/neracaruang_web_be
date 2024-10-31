<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
/**
 * @SWG\Definition(
 *      definition="EBook",
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
 *          property="author",
 *          description="author",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="image_uri",
 *          description="image_uri",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="rating",
 *          description="rating",
 *          type="float"
 *      ),
 *      @SWG\Property(
 *          property="download_uri",
 *          description="download_uri",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="download_count",
 *          description="download_count",
 *          type="integer"
 *      ),
 *      @SWG\Property(
 *          property="view_count",
 *          description="view_count",
 *          type="integer"
 *      ),
 *     @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="integer"
 * )
 */
class EBook extends Model
{
    use SoftDeletes;

    protected $connection = 'second_db';
    public $table = 'ebook';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'title',
        'slug',
        'author',
        'description',
        'image_uri',
        'rating',
        'download_uri',
        'download_count',
        'view_count',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'author' => 'string',
        'description' => 'string',
        'image_uri' => 'string',
        'rating' => 'float',
        'download_uri' => 'string',
        'is_active' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer',
    ];

     /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'author' => 'required',
        'description' => 'required',
        'rating' => 'required|numeric',
        'is_active' => 'required'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $model->slug = Str::slug($model->title);
                for ($i = 1; self::where('slug', $model->slug)->count() > 0; $i++) {
                    $model->slug = Str::slug($model->title) . '-' . $i;
                }
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
        static::updating(function ($model) {
            try {
                $model->slug = Str::slug($model->title);
                for ($i = 1; self::where('slug', $model->slug)->count() > 0; $i++) {
                    $model->slug = Str::slug($model->title) . '-' . $i;
                }
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
