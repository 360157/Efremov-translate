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
            'flag' => $this->flag,
            'flag_path' => $this->flag ? '/vendor/translate/img/flags/'.$this->flag.'.png' : '',
            'name' => $this->name,
            'index' => $this->index,
            'dir' => $this->dir ? 'rtl' : 'ltr',
            'countries' => $this->countries,
            'is_active' => $this->is_active,
            'is_default' => $this->is_default,
            'created_at' => strval($this->created_at),
            'updated_at' => strval($this->translateUpdatedAt()),
        ];
    }
}
