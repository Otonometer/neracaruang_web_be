<?php

namespace App\Repositories;

use App\Models\Role;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class RoleRepository
 * @package App\Repositories
 * @version March 30, 2021, 3:40 am UTC
 *
 * @method Role findWithoutFail($id, $columns = ['*'])
 * @method Role find($id, $columns = ['*'])
 * @method Role first($columns = ['*'])
*/
class RoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'guard_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
}
