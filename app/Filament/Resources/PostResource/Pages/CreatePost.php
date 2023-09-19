<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
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
            $data['attachment_type'] = 'image';
        } else {
            $data['attachment_type'] = 'file';
        }
        $data['user_id'] = auth()->id();
        $data['post_type_id'] = 3;
        return $data;
    }
}
