<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        parent::__construct();
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
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

        $user = User::firstOrCreate(
            [
                'email' => $email,
            ],
            [
                'name' => $name,
                'password' => '',
                'email' => $email,
            ]
        );

        auth()->login($user, true);

        return redirect(route('home'));
    }
}
