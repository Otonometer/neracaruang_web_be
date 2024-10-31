<?php

namespace App\Repositories;

use App\Models\Icon;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class IconRepository
 * @package App\Repositories
 * @version July 26, 2023, 8:09 am UTC
 *
 * @method Icon findWithoutFail($id, $columns = ['*'])
 * @method Icon find($id, $columns = ['*'])
 * @method Icon first($columns = ['*'])
*/
class IconRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
        'iconnable_type',
        'iconnable_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Icon::class;
    }
}
