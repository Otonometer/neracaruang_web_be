<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;


/**
 * @SWG\Definition(
 *      definition="City",
 *      required={""},
 *      @SWG\Property(
 *          property="province_code",
 *          description="province_code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="city_name",
 *          description="city_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="icon_map",
 *          description="icon_map",
 *          type="string"
 *      )
 * )
 */
class City extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'cities';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'province_code',
        'city_name',
        'slug',
        'icon_map'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'province_code' => 'string',
        'city_name' => 'string',
        'icon_map' => 'string'
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

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'id');
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

    public function slug() : Attribute
    {
        return Attribute::make(
            get: fn () => Str::slug($this->city_name)
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $model->slug = Str::slug($model->city_name);
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
        static::updating(function ($model) {
            try {
                $model->slug = Str::slug($model->city_name);
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
