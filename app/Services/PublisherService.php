<?php

namespace App\Services;

use App\Models\PublishStatus;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublisherService
{
    protected $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }


    // public function pubishTopic(string $topic, array $data)
    // {
    //     $publishResponse = [];
    //     $status = "";

    //     $this->subscriptionRepository->where('topic', $topic)->chunk(100, function ($subscribers) use ($data, $topic, &$publishResponse, $status) {
    //         if (count($subscribers) <= 0) {
    //             Log::debug("Publishing without subscribers.
    //             The instruction said to publish even if no subscriber's exist. If no subscriber exist,
    //             what url will the data be published to? Also saving compautation power by not publishing if no subscriber.");
    //             return;
    //         }

    //         foreach($subscribers as $subscriber) {
    //             $url = $subscriber->url .'/'.$topic;
    //             $response = Http::post($url, $data);

    //             if (!$response->successful()) {
    //                 $status = "failed";
    //             } else {
    //                 $status = "success";
    //             }

    //             $status = PublishStatus::create([
    //                 'url' => $subscriber->url,
    //                 'status' => $status,
    //                 'code' => $response->status(),
    //                 'data' => json_encode($data)
    //             ]);

    //             // add a cron job to retry all failed publishment

    //             $publishResponse[$subscriber->url] = $status;
    //         }
    //     });

    //     return $publishResponse;
    // }
}
