<?php

namespace Sashaef\TranslateProvider\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransResource extends JsonResource
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
            'group_id' => $this->group_id,
            'key' => $this->key,
            'items' => TransDataResource::collection($this->data),
        ];
    }
}
