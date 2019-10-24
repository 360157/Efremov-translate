<?php

namespace Sashaef\TranslateProvider\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransDataResource extends JsonResource
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
            "translation_id" => $this->translation_id,
            "lang_id" => $this->lang_id,
            "translation" => $this->translation ?? '',
            "status" => $this->status,
        ];
    }
}
