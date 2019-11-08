<?php

namespace Sashaef\TranslateProvider\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'type' => $this->type,
            'trans' => $this->trans.' / '.$this->not_trans,
            'created_at' => strval($this->created_at),
            'updated_at' => strval($this->updated_at),
        ];
    }
}
