<?php

namespace App\Services\Subscription;

use App\Repositories\Subscriber\SubscriberRepository;
use App\Repositories\Topic\TopicRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        // check if subscriber exists
        $subscriberExists = $this->subscriberRepository->where('url', $subscriberUrl)->first();

        // check if topic exists
        $topicExists = $this->topicRepository->where('topic', $topic)->first();

        if ($topicExists && $subscriberExists) {
            // check if matching subscriber/topic exists
            $subscriberAndTopicMatches = DB::table('subscriber_topic')->where('topic_id', $topicExists->id)->where('subscriber_id', $subscriberExists->id)->first();

            if ($subscriberAndTopicMatches) {
                throw new Exception('Subscription already exists for topic ' . $topic);
            }

            // no combo match found so just sync and return
            $topicExists->subscribers()->sync($subscriberExists->id);

            return ['topic' => $topicExists->topic, 'url' => $subscriberExists->url];
        }

        // fresh and new creation
        $topicCreated = $this->topicRepository->create(['topic' => $topic]);

        $subscriber = $this->subscriberRepository->create(['url' => $subscriberUrl]);

        $topicCreated->subscribers()->sync($subscriber->id);

        return ['topic' => $topicCreated->topic, 'url' => $subscriber->url];
    }
}
