<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController as ParentController;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

//class RegisterController extends Controller
class RegisterController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $request)
    {
        if ($user = User::whereEmail($request->input('email'))->wherePassword('')->first()) {
            return $this->syncAccountInfo($request, $user);
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return $this->respondValidationError($validator);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->registered($request, $user);

        return $this->respondCreated($user);
    }

    protected function respondValidationError(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return json()->unprocessableError($validator->errors()->all());
    }

    protected function respondCreated(User $user)
    {
        //Todo 로그인 하는 대신 JSON Web Token을 응답할 것이다.
        return json()->setMeta(['token' => \JWTAuth::fromUser($user)])->created();
    }
}
