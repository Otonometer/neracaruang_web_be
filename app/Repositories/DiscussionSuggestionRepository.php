<?php

namespace App\Repositories;

use App\Models\DiscussionSuggestion;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class DiscussionSuggestionRepository
 * @package App\Repositories
 * @version August 1, 2023, 3:25 am UTC
 *
 * @method DiscussionSuggestion findWithoutFail($id, $columns = ['*'])
 * @method DiscussionSuggestion find($id, $columns = ['*'])
 * @method DiscussionSuggestion first($columns = ['*'])
*/
class DiscussionSuggestionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'topic',
        'abstract',
        'user_id',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DiscussionSuggestion::class;
    }
}
