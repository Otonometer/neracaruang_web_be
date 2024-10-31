<?php

namespace App\Repositories;

use App\Models\Discussion;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class DiscussionRepository
 * @package App\Repositories
 * @version July 28, 2023, 4:09 am UTC
 *
 * @method Discussion findWithoutFail($id, $columns = ['*'])
 * @method Discussion find($id, $columns = ['*'])
 * @method Discussion first($columns = ['*'])
*/
class DiscussionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'summary',
        'content',
        'image',
        'reads',
        'likes',
        'moderator',
        'co_moderator',
        'publish_date_start',
        'publish_date_end',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Discussion::class;
    }
}
