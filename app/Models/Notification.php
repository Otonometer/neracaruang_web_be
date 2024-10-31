<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Notification",
 *      required={""},
 *      @SWG\Property(
 *          property="type",
 *          description="type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
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
 *          property="link_uri",
 *          description="link_uri",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="is_active",
 *          description="is_active",
 *          type="string"
 *      )
 * )
 */
class Notification extends Model
{
    use SoftDeletes;

    protected $connection = 'second_db';
    public $table = 'notification';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'type',
        'title',
        'description',
        'image_uri',
        'link_uri',
        'is_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'title' => 'string',
        'description' => 'string',
        'image_uri' => 'string',
        'link_uri' => 'string',
        'is_active' => 'integer'
    ];

     /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'title' => 'required',
        'description' => 'required',
        'link_uri' => 'required|url',
        'is_active' => 'required'
    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
