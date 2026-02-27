<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $lesson = $this->record;
        
        if ($lesson->wasChanged('video_url') && !str_contains($lesson->video_url, 'storage/lessons')) {
             \App\Jobs\UploadVideoJob::dispatch(
                $lesson,
                $lesson->video_url,
                auth()->user()
            );
        }
    }
}
