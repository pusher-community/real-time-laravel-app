<?php

namespace App\Http\Controllers;

use App\Events\ActivityEvent;
use App\Events\ActivityLikedEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class ActivityController extends Controller
{
    var $pusher;

    public function __construct()
    {
        $this->pusher = App::make('pusher');
    }

    /**
     * Serve the example activities view
     */
    public function getIndex()
    {
        $activity = new ActivityEvent( 'A user visited the Activities page' );
        $this->pusher->trigger('activities', 'user-visit', $activity);
        return view('activities');
    }

    /**
     * A new status update has been posted
     * @param Request $request
     */
    public function postStatusUpdate(Request $request)
    {
        $activity = new ActivityEvent( $request->input('status_text') );
        $this->pusher->trigger('activities', 'new-status-update', $activity);
    }

    /**
     * Like an activity
     * @param $id The ID of the activity that has been liked
     */
    public function postLike($id)
    {
        $activity = new ActivityLikedEvent( 'A user liked a status update', $id );
        $this->pusher->trigger('activities', 'status-update-liked', $activity);
    }
}
