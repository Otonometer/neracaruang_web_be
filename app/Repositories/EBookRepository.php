<?php

namespace App\Repositories;

use App\Models\EBook;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class EBookRepository
 * @package App\Repositories
 * @version August 11, 2023, 7:39 am UTC
 *
 * @method EBook findWithoutFail($id, $columns = ['*'])
 * @method EBook find($id, $columns = ['*'])
 * @method EBook first($columns = ['*'])
*/
class EBookRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'description',
        'image_uri',
        'link_uri',
        'is_active'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EBook::class;
    }
}
