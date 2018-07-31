<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        // 이 부분이 없으면 storage/logs/laravel.log 에 기록될 뿐 아니라,
        // production 환경에서는 Slack 으로 Exception 이 리포트된다.
        TokenExpiredException::class,
        TokenInvalidException::class,
        JWTException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        //예외 처리 테스트 추가
        if (is_api_request()) { //api 호출일 경우
            $code = method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : $exception->getCode();

            // Exception 별로 메시지를 다르게 처리한다.
            // 특히, 같은 400, 401 이라도 클라이언트가 이해하고 다음 액션을 취할 수 있는
            // 메시지를 주는 것이 중요하다. 해서 xxx_yyy 식의 영어 메시지를 쓰고 있다.
            if ($exception instanceof TokenExpiredException) {
                $message = 'token_expired';
            } elseif ($exception instanceof TokenInvalidException) {
                $message = 'token_invalid';
            } elseif ($exception instanceof JWTException) {
                $message = $exception->getMessage() ? : 'could_not_create_token';
            } elseif ($exception instanceof NotFoundHttpException) {
                $message = $exception->getMessage() ? : 'not_found';
            } elseif ($exception instanceof Exception) {
                $message = $exception->getMessage() ? : 'Something broken :(';
            }

            return json()->setStatusCode($code ? : 400)->error($message);
        } else { // 일반 페이지의 경우
            if ($exception instanceof ModelNotFoundException or $exception instanceof NotFoundHttpException) {
                return response(view('errors.notice', [
                    'title' => 'Page Not Fount',
                    'description' => 'Sorry, the page or resource trying to view does not exist.'
                ]), 404);
            }
        }
        //예외 처리 테스트 추가 끝

        return parent::render($request, $exception);
    }
}
