<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class ChatController extends Controller
{
    var $pusher;
    var $user;
    var $chatChannel;

    const DEFAULT_CHAT_CHANNEL = 'private-chat';

    public function __construct()
    {
        $this->pusher = App::make('pusher');
        $this->user = Session::get('user');
        $this->chatChannel = self::DEFAULT_CHAT_CHANNEL;
    }

    /**
     * Serve up the chat example app. Redirect if the user is not logged in.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getIndex()
    {
        if(!$this->user)
        {
            return redirect('auth/github?redirect=/chat');
        }

        return view('chat', ['chatChannel' => $this->chatChannel]);
    }

    /**
     * Handle a chat message POST request
     *
     * @param Request $request
     */
    public function postMessage(Request $request)
    {
        $message = [
            'text' => e($request->input('chat_text')),
            'username' => $this->user->getNickname(),
            'avatar' => $this->user->getAvatar(),
            'timestamp' => (time()*1000)
        ];
        $this->pusher->trigger($this->chatChannel, 'new-message', $message);
    }

    /**
     * Authenticate a subscription request.
     *
     * @param Request $request
     * @return Response
     */
    public function postAuth(Request $request)
    {
        if($this->user)
        {
            // TODO: should check if the $channelName has a 'private-' prefix.
            $channelName = $request->input('channel_name');
            $socketId = $request->input('socket_id');
            $auth = $this->pusher->socket_auth($channelName, $socketId);
            return $auth;
        }
        else
        {
            return (new Response('Not Authorized', 401));
        }
    }
}
