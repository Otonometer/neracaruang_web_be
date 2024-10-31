<?php

namespace App\Repositories;

use App\Models\Setting;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version September 11, 2020, 10:44 am UTC
 *
 * @method Setting findWithoutFail($id, $columns = ['*'])
 * @method Setting find($id, $columns = ['*'])
 * @method Setting first($columns = ['*'])
*/
class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'key',
        'value',
        'type',
        'created_by',
        'updated_by'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }
}
