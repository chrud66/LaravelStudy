<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

use App\Http\Controllers\Auth\LoginController as ParentController;
use Illuminate\Contracts\Validation\Validator;
use App\User;
use Socialite;
use Auth;

class LoginController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
        // ParentController 의 미들웨어 정의 무력화.
        $this->middleware = [];
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }

        $token = \JWTAuth::attempt($request->only('email', 'password'));

        if (! $token) {
            return $this->respondLoginFailed();
        }

        $this->authenticated($request, Auth::user());

        return $this->respondCreated($request->input('return'), $token);
    }

    protected function respondValidationError(Validator $validator)
    {
        return json()->unprocessableError($validator->errors()->all());
    }

    protected function respondLoginFailed()
    {
        return json()->unauthorizedError('invalid_credentials');
    }

    protected function respondCreated($return = '', $token = '')
    {
        // Todo 로그인 하는 대신 JSON Web Token 을 응답할 것이다.
        return json()->setMeta(['token' => $token])->created();
    }
}
