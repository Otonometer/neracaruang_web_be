<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Permission",
 *      required={""},
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="permission_group_id",
 *          description="permission_group_id",
 *          type="integer",
 *          format="int32"
 *      ),
 * )
 */
class Permissionlabel extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'permissions_label';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'permission_group_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'permission_group_id' => 'integer',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function permissiongroup()
    {
        return $this->hasOne(\App\Models\Permissiongroup::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsTo(\App\Models\Permission::class, 'id', 'permissions_label_id');
    }
}
