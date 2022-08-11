<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the given HttpException.
     *
     * @param  \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        if (! view()->exists("errors.{$e->getStatusCode()}")) {
            if ($e->getStatusCode() === 419) {
                $message = 'Expired security token';
            } else {
                $message = Response::$statusTexts[$e->getStatusCode()] ?? '';
            }
            return response()->view('errors.default',
                [
                    'code' => $e->getStatusCode(),
                    'message' => $message
                ],
                $e->getStatusCode(),
                $e->getHeaders());
        }

        return parent::renderHttpException($e);
    }
}
