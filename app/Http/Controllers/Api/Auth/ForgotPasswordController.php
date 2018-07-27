<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\ForgotPasswordController as ParentController;
use App\User;
use Password;

class ForgotPasswordController extends ParentController
{
    public function sendResetLinkEmail(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if (User::whereEmail($request->input('email'))->wherePassword('')->first()) {
            // Notify the user if he/she is a social login user.
            $message = sprintf("%s %s", __('auth.social_only'), __('auth.no_password'));

            return $this->respondError($message, 400);
        }

        $response = Password::sendResetLink($request->only('email'), function ($m) {
            $m->subject(__('auth.email_password_reset_title'));
        });

        return $response == Password::RESET_LINK_SENT
            ? $this->respondSuccess(__($response))
            : $this->respondError(__($response), 404);
    }

    protected function respondError($message, $statusCode = 400)
    {
        return json()->setStatusCode($statusCode)->error('not_found');
    }

    protected function respondSuccess($message)
    {
        return json()->success();
    }
}
