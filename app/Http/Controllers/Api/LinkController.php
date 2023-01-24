<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkCollection;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    private $links;
    public function __construct(LinkRepository $links)
    {
        $this->links = $links;
    }
    public function index()
    {
        $links = $this->links->all();
        return $this->sendJsonResponse(200, 'success', $links);

    }
    public function store(LinkRequest $request)
    {
        $data = $this->prepareData($request);
        $this->links->create($data);

        //redis
        $this->storeInRedis($data['unique_link']);

        return $this->sendJsonResponse(200, 'success');

    }

    public function clickLink($linkId)
    {
        $link = $this->updateInRedis($linkId);

        $this->links->update($link);
        return $this->sendJsonResponse(200, 'success');

    }
    public function getByNumberOfView($number)
    {
        $links = $this->readOfRedis($number);
        return $this->sendJsonResponse(200, 'success', $links);
    }
    public function prepareData($request): array
    {
        return [
            'main_link' => $request->main_link,
            'unique_link' => 'localhost/' . Str::random(5),
            'user_id' => $request->user_id
        ];
    }

    public function sendJsonResponse($code, $message, $data=null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }


    public function storeInRedis($unique_link): void
    {
        $linkId = Redis::command('incr', ['link_id']);
        $linkKey = "links:" . $linkId;
        Redis::hmset($linkKey,
            'id', $linkId,
            'unique_link', $unique_link,
            'view_number', 0,
        );
        Redis::zadd('view_number', 0, $linkKey);
    }

    public function updateInRedis($linkId)
    {
        $linkKey = "links:" . $linkId;
        Redis::hincrby($linkKey, "view_number", 1);
        $link = Redis::hgetall($linkKey);
        Redis::zadd('view_number', $link['view_number'], $linkKey);
        return $link;
    }


    public function readOfRedis($number): \Illuminate\Support\Collection
    {
        $links = collect();
        $linkIds = Redis::zrevrange('view_number', 1, $number);
        foreach ($linkIds as $linkId) {
            $links->push(Redis::hgetall($linkId));
        }
        return $links;
    }
}
