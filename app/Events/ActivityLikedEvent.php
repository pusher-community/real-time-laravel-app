<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityLikedEvent extends ActivityEvent
{
    public $likedActivityId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $likedActivityId)
    {
        parent::__construct($text);

        $this->likedActivityId = $likedActivityId;
    }
}
