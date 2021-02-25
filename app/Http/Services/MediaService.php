<?php


namespace App\Http\Services;


use App\Models\Media;

trait MediaService
{
    public function uploadFile($file, $path)
    {
        $file_ext = strtolower($file->getClientOriginalExtension());
        $date = '(' . date('Y-m-d') . ')';
        $fileName = $file->getClientOriginalName();
        $fileName = str_replace(' ', '', explode('.', $fileName)[0] . $date . '.' . $file_ext);
        $fileName = preg_replace('/[!@#$%^&]/', '', $fileName);
        $imagePath = public_path('upload/' . $path);
        $file->move($imagePath, $fileName);
        $local_path = 'upload/' . $path . '/' . $fileName;
        $url = env('APP_URL') . '/public/' . $local_path;
        return [
            $url,
            $local_path
        ];
    }

    public function makeMediaData($file, $path = 'media')
    {
        list($path, $local_path) = $this->uploadFile($file, $path);

        return [
            'file_name' => $file->getClientOriginalName(),
            'path' => $local_path,
            'url' => $path,
            'name' =>  pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'type' => Media::image_type
        ];
    }

}
