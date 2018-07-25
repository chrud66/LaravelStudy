<?php

namespace App\Http\Controllers\Api\Auth;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController as ParentController;
use App\User;
use Illuminate\Support\Facades\Validator;

//class RegisterController extends Controller
class RegisterController extends ParentController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function respondValidationError(Validator $validator)
    {
        return response()->json([
            'code' => 422,
            'errors' => $validator->errors()->all()
        ], 422);
    }

    protected function respondCreated(User $user)
    {
        //Todo 로그인 하는 대신 JSON Web Token을 응답할 것이다.
        return response()->json([
            'code' => 201,
            'message' => 'success',
            'token' => 'token here'
        ], 201);
    }
}
