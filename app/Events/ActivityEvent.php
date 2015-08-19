<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class ActivityEvent extends Event
{
    use SerializesModels;

    public $id;
    public $text;
    public $username;
    public $avatar;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $text)
    {
        $this->id = str_random();
        $this->text = e($text);

        $this->username = $user->getNickname();
        $this->avatar = $user->getAvatar();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
