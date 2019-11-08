<?php

namespace Sashaef\TranslateProvider\Resources;

use http\Client\Request;
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
            'description' => $this->description,
            'items' => $this->getTranslate($this->data, $request->langs),
        ];
    }

    private function getTranslate($translates, $langIds)
    {
        $arr = [];
        foreach ($translates as $translate) {
            if (in_array($translate->lang_id, $langIds)) {
                $arr['_'.$translate->lang_id] = $translate;
            }
        }

        return $arr;
    }
}
