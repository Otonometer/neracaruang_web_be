<?php

namespace App\Repositories;

use App\Models\City;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class CityRepository
 * @package App\Repositories
 * @version July 26, 2023, 8:03 am UTC
 *
 * @method City findWithoutFail($id, $columns = ['*'])
 * @method City find($id, $columns = ['*'])
 * @method City first($columns = ['*'])
*/
class CityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'province_code',
        'city_code',
        'city_name',
        'icon_map'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return City::class;
    }
}
