<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Subscription\SubscriptionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionApiController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * The publsher has to be aware of any subscription.
     * hence the need for this method
     */
    public function createSubscription(string $topic, Request $request)
    {
        try {
            $subscription = $this->subscriptionService->createSubscription($topic, $request->all());

            return response($subscription, 201);

        } catch (Exception $e) {
            Log::error("Failed to create subscription: ". $e->getMessage());
            return response([
                'message' => 'Failed to create subscription',
                'status' => false
            ], 400);
        }
    }
}
