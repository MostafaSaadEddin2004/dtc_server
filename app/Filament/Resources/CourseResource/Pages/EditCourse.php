<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $post = Post::where('course_id', $data['id'])->first();
        $data['content'] = $post->content;
        $data['attachment'] = $post->attachment;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $dataPost = $data;
        $dataCourse = $data;
        $keysToRemoveFromdataPost = [
            "name",
        ];
        $keysToRemoveFromdataCourse = [
            "user_id",
            'post_type_id',
            'attachment_type',
            'attachment',
            'content',
        ];
        // Remove specified keys from the array
        foreach ($keysToRemoveFromdataCourse as $key) {
            unset($dataCourse[$key]);
        }
        // Remove specified keys from the array
        foreach ($keysToRemoveFromdataPost as $key) {
            unset($dataPost[$key]);
        }

        return $data;
    }


    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
