<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessLog extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ip' => $this->ip,
            'response_type' => $this->response_type,
            'response_time' => $this->response_time,
            'country_of_origin' => $this->country_of_origin,
            'path' => $this->path,
        ];
    }
}
