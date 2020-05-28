<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Raion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'cod3' => $this->cod3,
                'name' => $this->name,
                ];
    }
}
