<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LinkCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'unique_link' => $item->unique_link,
                    'main_link' => $item->main_link,
                    'view_number' => $item->view_number,
                ];
            })
        ];
    }
}
