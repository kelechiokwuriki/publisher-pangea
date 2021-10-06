<?php

namespace App\Repositories\Topic;

use App\Models\Topic;
use App\Repositories\Base\BaseRepository;

class TopicRepository extends BaseRepository
{
    protected $topicModel;

    public function __construct(Topic $topicModel)
    {
        parent::__construct($topicModel);
    }
}
