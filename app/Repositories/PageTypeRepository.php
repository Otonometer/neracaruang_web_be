<?php

namespace App\Repositories;

use App\Models\PageType;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class PageTypeRepository
 * @package App\Repositories
 * @version July 25, 2023, 7:52 am UTC
 *
 * @method PageType findWithoutFail($id, $columns = ['*'])
 * @method PageType find($id, $columns = ['*'])
 * @method PageType first($columns = ['*'])
*/
class PageTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PageType::class;
    }
}
