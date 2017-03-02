<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use Illuminate\Contracts\Mail\Mailer;
class AlertEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $user, $subject, $content;

    public function __construct($user, $subject, $content)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::send(['text' => 'view'], [$this->content], function($message){
        //     $message->to($this->user)->subject($this->subject);

        // });
        Mail::raw($this->content, function ($message) 
        {
            $message->to($this->user)->subject($this->subject);
        });
    }
}
