<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Socialite;

class SocialController extends Controller
{
    public function execute(Request $request, $provider)
    {
        if (! $request->has('code')) {
            return $this->redirectToProvider($provider);
        }

        return $this->handleProviderCallback($provider);
    }

    /**
     * SocialLogin
     */
    public function redirectToProvider($social)
    {
        if ($social === 'naver') {
            return Socialite::with($social)->redirect();
        } else {
            return Socialite::driver($social)->redirect();
        }
    }

    public function handleProviderCallback($social)
    {
        $user = Socialite::driver($social)->user();

        $email = $user->getEmail();
        $name = $social === 'naver' ? $user->user['name'] : $user->getName();

        $user = (User::whereEmail($user->getEmail())->first())
        ?: User::create([
            'name' => $name,
            'password' => '',
            'email' => $email,
        ]);

        auth()->login($user, true);
        $user->syncRoles(['member']);

        return redirect(route('home'));
    }
}
