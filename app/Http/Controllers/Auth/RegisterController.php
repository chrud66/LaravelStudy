<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function store(Request $request)
    {
        if ($user = User::whereEmail($request->input('email'))->wherePassword('')->first()) {
            return $this->syncAccountInfo($request, $user);
        }

        return $this->register($request);
    }

    protected function syncAccountInfo(Request $request, User $user)
    {
        $validator = Validator::make($request->except('_token'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()) {
            //return back()->withInput()->withErrors($validator);
            return $this->respondValidationError($validator);
        }

        $user->update([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password'))
        ]);

        $this->guard()->login($user);
        flash(__('auth.welcome', ['name' => $user->name]));

        //return $this->registered($request, $user) ?: redirect($this->redirectPath());

        return $this->respondCreated($user);
    }

    protected function respondValidationError(Validator $validator)
    {
        return back()->withInput()->withErrors($validator);
    }

    protected function respondCreated(User $user)
    {
        \Auth::login($user);
        flash(__('auth.welcome', ['name' => $user->name]));

        return redirect(route('home'));
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
}
