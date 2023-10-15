<?php

namespace App\Filament\Resources\AcademicRegistrationResource\Pages;

use App\Filament\Resources\AcademicRegistrationResource;
use Filament\Pages\Actions;
use Spatie\Valuestore\Valuestore;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademicRegistration extends ViewRecord
{
    protected static string $resource = AcademicRegistrationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(function () {
                    $valueStore = ValueStore::make(config('filament-settings.path'));
                    return    $valueStore->get('registration_start_at') >= now() || $valueStore->get('registration_end_at') <= now();
                }),
                Actions\Action::make('accept')
                    ->action(function (AcademicRegistration $record) {
                        $valueStore = ValueStore::make(config('filament-settings.path'));
                        $record->update(['accepted' => true]);
                        $record->user->notifications()->create([
                            'title' => 'تسجيل الدخول',
                            'body' => 'تم قبول طلب تسجيلك بدورة ' . $record->department->name .'. يرجى القدوم في تاريخ ' . Carbon::parse($valueStore->get('interview_at'))->toDateString() . ' لعمل مقابلة.',
                        ]);
                        $record->user->update(['role_id' => 4]);
                        $record->department->students()->create(['user_id' => $record->user->id]);
                    }),
        ];
    }
}