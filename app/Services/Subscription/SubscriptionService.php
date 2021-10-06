<?php

namespace App\Services\Subscription;

use App\Repositories\Subscriber\SubscriberRepository;
use App\Repositories\Topic\TopicRepository;
use Exception;

class SubscriptionService
{
    protected $topicRepository;
    protected $subscriberRepository;

    public function __construct(TopicRepository $topicRepository, SubscriberRepository $subscriberRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->subscriberRepository = $subscriberRepository;
    }

    public function createSubscription(string $topic, array $data)
    {
        $subscriberUrl = $data['url'];

        // check if topic exists
        $topicExists = $this->topicRepository->where('topic', $topic)->first();

        if ($topicExists) {
            // check if matching subscriber/topic exists
            $subscriberExists = $this->subscriberRepository->where('topic_id', $topicExists->id)->where('url', $subscriberUrl)->first();

            if ($subscriberExists) {
                throw new Exception('Subscription already exists for topic ' . $topic);
            }

            return $this->subscriberRepository->create([
                'topic_id' => $topicExists->id,
                'url' => $subscriberUrl
            ]);
        }

        // fresh and new creation
        $topicCreated = $this->topicRepository->create(['topic' => $topic]);

        $subscriptionData = [
            'topic_id' => $topicCreated->id,
            'url' => $subscriberUrl
        ];

        $subscriber = $this->subscriberRepository->create($subscriptionData);

        return ['topic' => $topicCreated->topic, 'url' => $subscriber->url];
    }
}
