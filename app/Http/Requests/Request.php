<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the request is update
     *
     * @return bool
     */
    protected function isUpdate()
    {
        $needle = ['put', 'patch'];

        return in_array(strtolower($this->input('_method')), $needle)
            or in_array(strtolower($this->header('x-http-method-override')), $needle)
            or in_array(strtolower($this->method()), $needle);
    }

    /**
     * Determine if the request is delete
     *
     * @return bool
     */
    protected function isDelete()
    {
        $needle = ['delete'];

        return in_array(strtolower($this->input('_method')), $needle)
            or in_array(strtolower($this->header('x-http-method-override')), $needle)
            or in_array(strtolower($this->method()), $needle);
    }

    public function response(array $errors)
    {
        if (is_api_request()) {
            // API 요청인데, 입력값 유효성 검사에 실패했을 때, 그래서 response() 메소드에 왔을 때는
            // 부모 클래스인 Illuminate\Foundation\Http\FormRequest::response() 를
            // Override 해서 여기서 바로 JSON 응답을 우리 API 응답 포맷에 맞도록 내 보낸다.
            return json()->unprocessableError($errors);
        }

        // parent::response() 를 사용하지 않고, 완전히 Overwriting 하였다.
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

    public function forbiddenResponse()
    {
        if (is_api_request()) {
            //역시 위와 동일하다.
            return json()->forbiddenError();
        }

        return response('Forbidden', 403);
    }
}
