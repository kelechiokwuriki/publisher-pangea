<?php

namespace App\Repositories\Subscriber;

use App\Models\Subscriber;
use App\Repositories\Base\BaseRepository;

class SubscriberRepository extends BaseRepository
{
    protected $subscriberModel;

    public function __construct(Subscriber $subscriberModel)
    {
        parent::__construct($subscriberModel);
    }
}
