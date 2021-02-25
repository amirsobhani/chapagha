<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaInsertRequest;
use App\Http\Requests\MediaResizeRequest;
use App\Http\Resources\BasicResource;
use App\Http\Services\MediaService;
use App\Models\Media;
use App\Models\MediaConversion;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    use MediaService;

    public function store(MediaInsertRequest $request)
    {

        $data = $this->makeMediaData($request->file('file'), 'media');

        $media = Media::create($data);

        return response(new BasicResource(['data' => $media]));

    }

    public function convert(Media $media, MediaResizeRequest $request)
    {
        $inputs = $request->all();

        $imagick = new \Imagick($media->path);

        $imagick->scaleImage($inputs['width'], $inputs['height'], true, true);
        $offsetX = $inputs['padding'] / 2;
        $offsetY = $inputs['padding'] / 2;
        $new_width = $inputs['padding'] + $imagick->getImageWidth();
        $new_height = $inputs['padding'] + $imagick->getImageHeight();

        $imagick->extentImage($new_width, $new_height, -$offsetX, -$offsetY);
        $new_file_name = $media->name . '-' . $inputs['width'] . 'x' . $inputs['height'] . '.jpg';
        $imagick->writeImage($new_file_name);

        if (!File::exists(public_path('upload/media-conversion'))) {
            File::makeDirectory(public_path('upload/media-conversion'));
        }

        File::move(public_path($new_file_name), public_path('upload/media-conversion/' . $new_file_name));

        $media_conversion = MediaConversion::firstOrCreate(
            [
                'media_id' => $media->id,
                'width' => $inputs['width'],
                'height' => $inputs['height'],
                'padding' => $inputs['padding'],
            ],
            [
                'name' => pathinfo($new_file_name, PATHINFO_FILENAME),
                'file_name' => $new_file_name,
                'path' => public_path('upload/media-conversion/' . $new_file_name),
                'url' => env('APP_URL') . public_path('upload/media-conversion/' . $new_file_name),
            ]
        );

        return response(new BasicResource(['data' => $media_conversion]));

//        header("Content-Type: image/png");
//        echo $imagick->getImageBlob();
    }


}
