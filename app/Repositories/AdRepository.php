<?php

namespace App\Repositories;

use App\Models\Ad;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class AdRepository
 * @package App\Repositories
 * @version July 26, 2023, 8:12 am UTC
 *
 * @method Ad findWithoutFail($id, $columns = ['*'])
 * @method Ad find($id, $columns = ['*'])
 * @method Ad first($columns = ['*'])
*/
class AdRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'image',
        'location_id',
        'location_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ad::class;
    }
}
