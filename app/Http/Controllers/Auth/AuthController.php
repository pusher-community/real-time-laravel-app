<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Socialite;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param Request $request
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        return Socialite::driver('github')
            ->with(['redirect_uri' => env('GITHUB_CALLBACK_URL' ) . '?redirect=' . $request->input('redirect')])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('github')->user();

        Session::put('user', $user);

        $redirect = $request->input('redirect');
        if($redirect)
        {
            return redirect($redirect);
        }
    }
}