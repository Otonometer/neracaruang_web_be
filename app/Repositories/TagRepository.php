<?php

namespace App\Repositories;

use App\Models\Tag;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class TagRepository
 * @package App\Repositories
 * @version July 26, 2023, 8:11 am UTC
 *
 * @method Tag findWithoutFail($id, $columns = ['*'])
 * @method Tag find($id, $columns = ['*'])
 * @method Tag first($columns = ['*'])
*/
class TagRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'category_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Tag::class;
    }
}
