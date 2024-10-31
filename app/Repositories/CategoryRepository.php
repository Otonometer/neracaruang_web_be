<?php

namespace App\Repositories;

use App\Models\Category;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version July 26, 2023, 8:10 am UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class CategoryRepository extends BaseRepository
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
        return Category::class;
    }
}
