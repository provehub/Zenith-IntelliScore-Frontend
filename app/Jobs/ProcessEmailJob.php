<?php

namespace App\Jobs;

use Throwable;
use App\Models\User;

use App\Mail\GeneralEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $useremail;
    protected $userename;
    protected $subject;
    protected $message;
    protected $url;

     /**
     * Create a new job instance.
     */
    public function __construct($useremail, $userename, $subject, $message, $url)
    {
        $this->useremail = $useremail;
        $this->userename = $userename;
        $this->subject = $subject;
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->useremail)->send(new GeneralEmail($this->userename,$this->subject,$this->message,$this->url));
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        // Send user notification of failure, etc...
        $subject = 'Email Job Failure for Events';
        $messagetosend = $exception;
        Mail::to('support@Zenith IntelliScore.ng')->send(new GeneralEmail('Job Emails','New Error Received',$messagetosend,$this->url));
    }
}
