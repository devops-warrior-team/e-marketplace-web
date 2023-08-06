<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Exception;
use App\Models\User;

class SocialiteLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback(){
        try {
            //create a user using socialite driver google
            $user = Socialite::driver('google')->stateless()->user();
            // if the user exits, use that user and login
            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                //if the user exists, login and show dashboard
                Auth::login($finduser);
                return redirect()->intended(RouteServiceProvider::HOME);
            }else{
                //user is not yet created, so create first
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'email_verified_at' => date('Y-m-d H:i:s'),//autoverified cause use email account google
                    'password' => encrypt('')
                ]);
                $newUser->save();
                //login as the new user
                Auth::login($newUser);
                // go to the dashboard
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }catch(Exception $e){
            return redirect('/login');
        }
    }
}
