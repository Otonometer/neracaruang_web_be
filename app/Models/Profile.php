<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Profile",
 *      required={""},
 *      @SWG\Property(
 *          property="province",
 *          description="province",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="city",
 *          description="city",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="postal_code",
 *          description="postal_code",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Profile extends Model
{
    // use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'profile';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'province',
        'city',
        'postal_code',
        'dob',
        'image',
        'phone'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'province' => 'string',
        'city' => 'string',
        'postal_code' => 'integer',
        'image' => 'string',
        'phone' => 'string',
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
        return $this->hasOne(Province::class, 'id', 'province');
    }

    public function cities()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

}
