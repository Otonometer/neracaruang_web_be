<?php

namespace App\Repositories;

use App\Models\SocialMedia;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class SocialMediaRepository
 * @package App\Repositories
 * @version August 11, 2023, 7:39 am UTC
 *
 * @method SocialMedia findWithoutFail($id, $columns = ['*'])
 * @method SocialMedia find($id, $columns = ['*'])
 * @method SocialMedia first($columns = ['*'])
*/
class SocialMediaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'url',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SocialMedia::class;
    }
}
