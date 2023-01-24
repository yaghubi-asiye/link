<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Repositories\LinkRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    private $links;
    public function __construct(LinkRepository $links)
    {
        $this->links = $links;
    }
    public function index(): JsonResponse
    {
        $links = $this->links->all();
        return $this->sendJsonResponse(200, 'success', $links);

    }
    public function store(LinkRequest $request)
    {
        $data = $this->prepareData($request);
        $this->links->create($data);
        return $this->sendJsonResponse(200, 'success');

    }

    /**
     * @param LinkRequest $request
     * @return array
     */
    public function prepareData($request): array
    {
        return [
            'main_link' => $request->main_link,
            'unique_link' => 'localhost/' . Str::random(5),
            'user_id' => $request->user_id
        ];
    }

    /**
     * @param $data
     * @param $code
     * @param $message
     * @return JsonResponse
     */
    public function sendJsonResponse($code, $message, $data=null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
