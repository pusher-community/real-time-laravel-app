<?php

namespace App\Events;

class ActivityLikedEvent extends ActivityEvent
{
    public $likedActivityId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $text, $likedActivityId)
    {
        parent::__construct($user, $text);

        $this->likedActivityId = $likedActivityId;
    }
}
