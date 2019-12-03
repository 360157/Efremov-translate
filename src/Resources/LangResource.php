<?php

namespace Sashaef\TranslateProvider\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LangResource extends JsonResource
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
            'index' => $this->index,
            'is_active' => $this->is_active,
            'created_at' => strval($this->created_at),
            'updated_at' => strval($this->translateUpdatedAt()),
        ];
    }
}
