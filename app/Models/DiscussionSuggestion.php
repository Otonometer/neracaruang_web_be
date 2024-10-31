<?php

namespace App\Models;

use App\User;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="DiscussionSuggestion",
 *      required={""},
 *      @SWG\Property(
 *          property="topic",
 *          description="topic",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="abstract",
 *          description="abstract",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      )
 * )
 */
class DiscussionSuggestion extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    public $table = 'discussion_suggestions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'topic',
        'abstract',
        'user_id',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'topic' => 'string',
        'abstract' => 'string',
        'user_id' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
