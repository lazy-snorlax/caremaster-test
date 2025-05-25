<?php

namespace App\Http\Resources;

use App\Http\Resources\AbilityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'abilities' => $this->whenLoaded('abilities', function () {
                return AbilityResource::collection($this->abilities->where('name', '<>', '*'));
            }),
        ];
    }
}
