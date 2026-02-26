<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Mail::to($this->user->email)->send(new \App\Mail\WelcomeMail($this->user));
    }
}
