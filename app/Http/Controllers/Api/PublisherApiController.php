<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PublisherService;
use Exception;
use Illuminate\Support\Facades\Log;

class PublisherApiController extends Controller
{
    protected $publisherService;

    public function __construct(PublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function publishTopic($topic, Request $dataRequest)
    {
        try {
            $response =  $this->publisherService->publishTopic($topic, $dataRequest->all());
            return response([
                'message' => 'publish successful',
                'data' => $response
            ], 200);
        } catch (Exception $e) {
            Log::error("Failed to publish data: ". $e->getMessage());
            return response([
                'message' => 'Failed to publish data',
                'status' => false
            ], 400);
        }
    }
}
