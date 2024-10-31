<?php

namespace App\Repositories;

use App\Models\Meta;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class MetaRepository
 * @package App\Repositories
 * @version August 28, 2023, 8:37 pm WIB
 *
 * @method Meta findWithoutFail($id, $columns = ['*'])
 * @method Meta find($id, $columns = ['*'])
 * @method Meta first($columns = ['*'])
*/
class MetaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'keyword'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Meta::class;
    }
}
