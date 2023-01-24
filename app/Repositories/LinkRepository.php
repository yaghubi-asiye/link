<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    public function all()
    {
        return Link::query()
            ->with('user')
            ->select(['unique_link', 'main_link', 'view_number', 'user_id'])
            ->orderBy('id', 'desc')
            ->get();
    }

    public function create(array $data)
    {
        return Link::query()->create($data);
    }
    public function getByNumberOfView($col, $value, $limit = 15)
    {
        return Link::where($col, $value)->limit($limit)->get();
    }


}
