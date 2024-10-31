<?php

namespace App\Repositories;

use App\Models\Permissiongroup;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class PermissiongroupRepository
 * @package App\Repositories
 * @version June 23, 2023, 9:53 am UTC
 *
 * @method Permissiongroup findWithoutFail($id, $columns = ['*'])
 * @method Permissiongroup find($id, $columns = ['*'])
 * @method Permissiongroup first($columns = ['*'])
*/
class PermissiongroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permissiongroup::class;
    }
}
