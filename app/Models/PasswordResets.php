<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="PasswordResets",
 *      required={""},
 *      @SWG\Property(
 *          property="email",
 *          description="email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="token",
 *          description="token",
 *          type="string"
 *      )
 * )
 */
class PasswordResets extends Model
{
    // use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'password_resets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;


    protected $dates = null;

    protected $primaryKey = 'email';


    public $fillable = [
        'email',
        'token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'token' => 'string'
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


}
