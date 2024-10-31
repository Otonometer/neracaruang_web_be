<?php

namespace App\Repositories;

use App\Models\Content;
use Illuminate\Support\Facades\DB;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class ContentRepository
 * @package App\Repositories
 * @version July 25, 2023, 7:57 am UTC
 *
 * @method Content findWithoutFail($id, $columns = ['*'])
 * @method Content find($id, $columns = ['*'])
 * @method Content first($columns = ['*'])
*/
class ContentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'summary',
        'content',
        'video',
        'page_type_id',
        'image',
        'location_id',
        'location_type',
        'reads',
        'likes'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Content::class;
    }

    public function getContentIdsForSearchedTags(array $tags) :array
    {
        $contentIds = DB::table('content_tags')
        ->whereIn('tag_id', $tags)
        ->groupBy('content_id')
        ->havingRaw('COUNT(DISTINCT tag_id) = ' . count($tags))
        ->pluck('content_id')
        ->toArray();

        return $contentIds;
    }
}
