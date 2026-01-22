<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Throwable;

class ErrorReported extends Mailable
{
    use Queueable, SerializesModels;

    public $exception;
    public $stackTrace;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
        $this->stackTrace = $this->filterStackTrace($exception);
    }

    protected function filterStackTrace(Throwable $exception)
    {
        $trace = collect($exception->getTrace())->map(function ($traceLine) {
            return Arr::only($traceLine, ['file', 'line', 'function']); // Filter for relevant info
        })->filter(function ($traceLine) {
            return isset($traceLine['file']) && strpos($traceLine['file'], app_path()) !== false; // Focus on app directory
        })->take(5); // Limit the number of trace lines to avoid overwhelming the email

        return $trace;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.emails.errorReported', ['exception' => $this->exception, 'stackTrace' => $this->stackTrace]);
    }

}
