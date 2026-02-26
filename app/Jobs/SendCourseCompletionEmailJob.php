<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCourseCompletionEmailJob implements ShouldQueue
{
    use Queueable;

    public $user;
    public $course;

    /**
     * Create a new job instance.
     */
    public function __construct(\App\Models\User $user, \App\Models\Course $course)
    {
        $this->user = $user;
        $this->course = $course;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Mail::to($this->user->email)->send(
            new \App\Mail\CourseCompletionMail($this->user, $this->course)
        );
    }
}
