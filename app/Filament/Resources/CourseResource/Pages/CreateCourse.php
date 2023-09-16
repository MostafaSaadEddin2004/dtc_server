<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Models\Post;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
    protected function handleRecordCreation(array $data): Model
    {

        $dataPost=$data;
        $dataCourse=$data;
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

        // // Create the record
        $createdPost=Post::create($dataPost);
        return static::getModel()::create($dataCourse);
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $file_path = $data['attachment']; // Replace with your actual file path

        // Get the file extension
        $file_info = pathinfo($file_path);
        $file_extension = strtolower($file_info['extension']);

        // Define an array of image file extensions
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

        // Check if the file extension is in the list of image extensions
        if (in_array($file_extension, $image_extensions)) {
            $data['attachment_type']='image';
        } else {
            $data['attachment_type']='file';
        }
        $data['user_id']=auth()->id();
        $data['post_type_id']=2;
        return $data;
    }

}
