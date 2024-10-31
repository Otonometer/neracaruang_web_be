<?php

namespace App\Repositories;

use App\Models\Permission;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class PermissionRepository
 * @package App\Repositories
 * @version March 30, 2021, 3:39 am UTC
 *
 * @method Permission findWithoutFail($id, $columns = ['*'])
 * @method Permission find($id, $columns = ['*'])
 * @method Permission first($columns = ['*'])
*/
class PermissionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'guard_name',
        'permissions_label_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
