<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Icon",
 *      required={""},
 *      @SWG\Property(
 *          property="image",
 *          description="image",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="iconnable_type",
 *          description="iconnable_type",
 *          type="string"
 *      )
 * )
 */
class Icon extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'icons';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'image',
        'iconnable_type',
        'iconnable_id',
        'color'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'image' => 'string',
        'iconnable_type' => 'string',
        'color' => 'string'
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

    public function iconnable()
    {
        return $this->morphTo();
    }
}
