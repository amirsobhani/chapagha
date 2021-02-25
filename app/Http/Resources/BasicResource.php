<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class BasicResource extends JsonResource
{
    protected $data,$message,$error_message,$errors,$count;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->count = isset($this['count']) ? $this['count'] : null;
        $this->message = isset($this['message']) ? $this['message'] : null;
        $this->error_message = isset($this['error_message']) ? $this['error_message'] : null;
        $this->errors = isset($this['errors']) ? $this['errors'] : null;
        $this->data = isset($this['data']) ? $this['data'] : new stdClass();
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message,
            'error' => [
                'message' => $this->error_message,
                'errors' => $this->errors
            ],
            "count" => $this->count,
            "data" => $this->data
        ];
    }
}
