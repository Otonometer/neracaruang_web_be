<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsContent extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'content_tags';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'tag_id'
    ];

}
