<?php

namespace App\Console\Commands;

use App\Models\EmailQueue;
use Illuminate\Console\Command;
use Mail;

class SendEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:emailqueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the email queue for emails to send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emailsToSend = EmailQueue::query()->limit(10)->get();

        foreach ($emailsToSend as $emailRequest)
        {
            if(isset($emailRequest->email_bcc))
            {
                \Log::info('bcc :::' .$emailRequest->email_bcc);
                Mail::html($emailRequest->content, function ($message) use($emailRequest) {
                    $message->to($emailRequest->email)
                        ->bcc($emailRequest->email_bcc)
                        ->subject($emailRequest->subject);
                });
                $emailRequest->delete();
            }else{
                Mail::html($emailRequest->content, function ($message) use($emailRequest) {
                    $message->to($emailRequest->email)
                        ->subject($emailRequest->subject);
                });
                $emailRequest->delete();
            }

        }
    }
}
