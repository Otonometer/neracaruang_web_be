<?php

namespace App\Repositories;

use App\Models\Province;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class ProvinceRepository
 * @package App\Repositories
 * @version July 25, 2023, 8:02 am UTC
 *
 * @method Province findWithoutFail($id, $columns = ['*'])
 * @method Province find($id, $columns = ['*'])
 * @method Province first($columns = ['*'])
*/
class ProvinceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'province_name',
        'icon_map'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Province::class;
    }
}
