<?php

namespace App\Exceptions;

use App\Mail\ErrorReported;
use GuyWarner\GoogleChatAlerts\Facades\GoogleChatAlert;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Mail;


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
        'current_password',
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
            GoogleChatAlert::message(
                "There's a new Error At : " . now()->toDayDateTimeString()
                . "Request URL : " . request()->fullUrl()

                . "        Message : " . $e->getMessage()
            );
            Mail::to(env('OWNER_EMAIL_BCC_NOTIFICATION'))
                ->cc([env('DEVELOPER_EMAIL_ERROR_NOTIFICATION')])
                ->send(new ErrorReported($e));
        });
    }
}
