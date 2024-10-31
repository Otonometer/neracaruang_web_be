<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentCommentReply extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    public function replies()
    {
        return $this->hasMany($this::class,'reply_id','id');
    }
}
