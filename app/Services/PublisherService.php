<?php

namespace App\Services;

use App\Models\PublishStatus;
use App\Repositories\Subscriber\SubscriberRepository;
use App\Repositories\Topic\TopicRepository;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublisherService
{
    protected $topicRepository;
    protected $subscriberRepository;

    public function __construct(TopicRepository $topicRepository, SubscriberRepository $subscriberRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->subscriberRepository = $subscriberRepository;
    }

    public function publishTopic(string $topic, array $message)
    {
        $topicExists = $this->topicRepository->where('topic', $topic)->first();
        $status = '';
        $publishResponses = [];
        $data = [
            'topic' => $topic,
            'data' => $message
        ];

        if (!$topicExists) throw new Exception('Topic does not exist');

        if (count($topicExists->subscribers) > 0) {
            $subscribers = $topicExists->subscribers;

            foreach($subscribers as $subscriber) {
                $url = $subscriber->url.'/api/subscription';
                Log::debug($url);

                $response = Http::post($url, $data);

                if ($response->successful()) {
                    $status = 'success';
                } else {
                    $status = 'failed';
                }

                $publishStatus = PublishStatus::create([
                    'subscriber_id' => $subscriber->id,
                    'status' => $status,
                    'status_code' => $response->status(),
                    'data' => json_encode($data)
                ]);

                $publishResponses[$subscriber->url] = $publishStatus;
            }

            return $publishResponses;
        }

        Log::debug("Subscribers do not exist for topic: " .$topic);
        return $publishResponses;
    }
}
