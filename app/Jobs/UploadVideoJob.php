<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Lesson $lesson,
        public string $tempPath,
        public User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Move file from temporary storage to public disk
        $fileName = 'video_' . $this->lesson->id . '_' . time() . '.' . pathinfo($this->tempPath, PATHINFO_EXTENSION);
        $finalPath = 'lessons/videos/' . $fileName;

        if (Storage::disk('public')->put($finalPath, Storage::disk('local')->get($this->tempPath))) {
            // Update Database
            $this->lesson->update([
                'video_url' => Storage::url($finalPath),
            ]);

            // Clean up temp file
            Storage::disk('local')->delete($this->tempPath);

            // Send Notification
            Notification::make()
                ->title('Video Uploaded Successfully')
                ->body("The video for lesson \"{$this->lesson->title}\" has been processed and saved.")
                ->success()
                ->sendToDatabase($this->user);
        } else {
            Notification::make()
                ->title('Video Upload Failed')
                ->body("There was an error processing the video for lesson \"{$this->lesson->title}\".")
                ->danger()
                ->sendToDatabase($this->user);
        }
    }
}
