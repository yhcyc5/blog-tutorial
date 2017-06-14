<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Auth;
use App\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        //Auth::logout();

        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $request = Socialite::driver('facebook')->user();

        if (User::where('name' , $request->getName())->first() == null) {
            User::create([
                'name' => $request->getName(),
                'email'    => $request->getEmail()
            ]);
        }
        $user = User::where('name' , $request->getName())->first();

        Auth::loginUsingId($user->id, true);

        return redirect()->route('home');
    }
}