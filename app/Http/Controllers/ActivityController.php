<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    var $pusher;
    var $user;

    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
    }

    /**
     * Serve the example activities view
     */
    public function getIndex()
    {
        if(!$this->user)
        {
            return redirect('auth/github?redirect=/activities');
        }

        $activity = [
            'text' => $this->user->getNickname() . ' visited the Activities page',
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => str_random()
        ];
        $this->pusher->trigger('activities', 'user-visit', $activity);
        return view('activities');
    }

    /**
     * A new status update has been posted
     * @param Request $request
     */
    public function postStatusUpdate(Request $request)
    {
        $activity = [
            'text' => $request->input('status_text'),
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => str_random()
        ];
        $this->pusher->trigger('activities', 'new-status-update', $activity);
    }

    /**
     * Like an activity
     * @param $id The ID of the activity that has been liked
     */
    public function postLike($id)
    {
        $activity = [
            'text' => $this->user->getNickname() . ' liked a status update',
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'id' => str_random(),
            'likedActivityId' => $id
        ];
        $this->pusher->trigger('activities', 'status-update-liked', $activity);
    }
}
