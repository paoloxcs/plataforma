<?php

namespace App\Http\Controllers;

use App\Interes;
use Illuminate\Http\Request;
use App\SocialProfile;
use Session;
use App\User;
use Illuminate\Support\Facades\Auth;
use Socialite;

class SocialProfileController extends Controller
{
    
    protected  $redirectTo = '/';
    
    public function redirectToProvider($driver)
    {
        //Validar la ruta con las applicacion para iniciar session => 'facebook','google'
                $drivers = ['google', 'facebook'];
        // $drivers = ['google'];

        if (in_array($driver, $drivers)) {
            return Socialite::driver($driver)->redirect();
        } else {
            Session::flash('msg-error', $driver . ' no es una aplicacion valida para poder logearse');
            return redirect()->route('home')->with('info', $driver . ' no es una aplicacion valida para poder logearse');
        }
    }
    
    
    public function redirectTo()
    {
        if (session()->has('redirect_to'))
            return session()->pull('redirect_to');

        return $this->redirectTo;
    }

    public function handleGoogleCallback(Request $request, $driver)
    {
        if ($request->get('error')) {
            return redirect()->route('home');
        }

        try {
            $userSocialite = Socialite::driver($driver)->user();

            $bolRedirect = false;

            $social_profile = SocialProfile::where('social_id', $userSocialite->getId())
                ->where('social_name', $driver)
                ->first();

            if (!$social_profile) {
                $user = User::where('email', $userSocialite->getEmail())->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $userSocialite->getName(),
                        'last_name' => '',
                        'email' => $userSocialite->getEmail(),
                        'phone_number' => '',
                        'password' => '',
                        'pais' => 'Otro',
                        'role_id' => 7,
                    ]);

                    Interes::create([
                        'user_id'   =>  $user->id,
                        'medio_id'  => '1',
                    ]);

                    $bolRedirect = true;
                }

                $social_profile = SocialProfile::create([
                    'user_id' => $user->id,
                    'social_id' => $userSocialite->getId(),
                    'social_name' => $driver,
                    'social_avatar' => $userSocialite->getAvatar(),
                ]);
            }

            Auth::login($social_profile->user);
            if ($bolRedirect) {
                // return redirect()->route('getmicuenta');
                
                return redirect($this->redirectTo());
             
            } else {
                return redirect()->route('home');
            }
        } catch (\Throwable $th) {
            return 'Halgo salio mal !' . $th->getMessage();
        }
    }
}
