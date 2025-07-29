<?php

namespace App\Jobs;

use App\Mail\SendOtpCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerifyJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $email,public $code)
    {

    }

    /**
     * Execute the job,
     */
    public function handle(): void
    {
         Mail::to($this->email)->send(new SendOtpCodeMail($this->code));
    }
}
