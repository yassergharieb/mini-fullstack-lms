<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function afterCreate(): void
    {
        $lesson = $this->record;
        
        // Dispatch job with temp path on local disk
        \App\Jobs\UploadVideoJob::dispatch(
            $lesson,
            $lesson->video_url, // This is the relative path in 'local' disk
            auth()->user()
        );
    }
}
