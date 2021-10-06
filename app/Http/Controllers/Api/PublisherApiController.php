<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublishDataRequest;
use Illuminate\Http\Request;
use App\Services\PublisherService;
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
        return $this->publisherService->pubishTopic($topic, $dataRequest->all());
    }
}
