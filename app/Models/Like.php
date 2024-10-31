<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Like",
 *      required={""},
 *      @SWG\Property(
 *          property="likeable_type",
 *          description="likeable_type",
 *          type="string"
 *      )
 * )
 */
class Like extends Model
{
    // use SoftDeletes;
    protected $connection = 'mysql';
    public $table = 'likes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'user_id',
        'likeable_type',
        'likeable_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

    protected $casts = [
        'likeable_type' => 'string'
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

    public function likeable()
    {
        return $this->morphTo();
    }
}
