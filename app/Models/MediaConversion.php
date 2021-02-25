<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaConversion extends Model
{
    protected $table = 'media_conversion';

    protected $fillable = [
        'media_id',
        'name',
        'file_name',
        'path',
        'url',
        'width',
        'height',
        'padding'
    ];

    public function media()
    {
        $this->belongsTo(Media::class);
    }
}
