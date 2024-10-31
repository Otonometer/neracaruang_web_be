<?php

namespace App\Repositories;

use App\Models\Notification;
use Webcore\Generator\Common\BaseRepository;

/**
 * Class NotificationRepository
 * @package App\Repositories
 * @version August 11, 2023, 7:39 am UTC
 *
 * @method Notification findWithoutFail($id, $columns = ['*'])
 * @method Notification find($id, $columns = ['*'])
 * @method Notification first($columns = ['*'])
*/
class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'title',
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
        return Notification::class;
    }
}
