<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMedia extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'content_medias';

    protected $fillable = [
        'content_id',
        'media_type',
        'image',
        'summary',
        'video',
        'documented_by',
        'cms_document_label',
        'cms_document_value'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class,'content_id','id');
    }
}
