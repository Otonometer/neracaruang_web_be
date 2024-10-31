<?php

namespace App\Repositories;

use App\User;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version March 30, 2021, 4:39 am UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
