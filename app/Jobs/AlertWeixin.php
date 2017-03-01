<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Weixin;

class AlertWeixin extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $user, $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $content)
    {
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    
    public function handle(Weixin $wx)
    {
        return $wx->sendMsg($this->user, $this->content);
    }
    
    /*
    public function handle()
    {
        $weixin = new Weixin;
        $weixin->sendMsg($this->content, $this->user);
    }*/
}
