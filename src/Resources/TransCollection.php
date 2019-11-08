<?php

namespace Sashaef\TranslateProvider\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Sashaef\TranslateProvider\Models\Langs;

class TransCollection extends ResourceCollection
{
    public $collects = 'Sashaef\TranslateProvider\Resources\TransResource';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'recordsTotal' => $this->total(),
            'recordsFiltered' => $this->total(),
        ];
    }
}
