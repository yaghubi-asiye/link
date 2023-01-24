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

    public function update( array $data)
    {
        return Link::where('id', $data['id'])
            ->update(['view_number' => $data['view_number']]);
    }

}
