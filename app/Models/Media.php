<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    const image_type = 'image';

    protected $fillable = [
        'name',
        'file_name',
        'path',
        'url',
        'type'
    ];

    public function conversion()
    {
        $this->hasMany(MediaConversion::class);
    }
}
