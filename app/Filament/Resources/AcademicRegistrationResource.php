<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicRegistrationResource\Pages;
use App\Models\AcademicRegistration;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class AcademicRegistrationResource extends Resource
{
    protected static ?string $model = AcademicRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        $builder = parent::getEloquentQuery()->withoutGlobalScopes();
        if (request()->routeIs('filament.resources.academic-registrations.view')) {
            return $builder;
        }
        return $builder->whereNull('accepted');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'first_name_en')
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required(),
                Forms\Components\TextInput::make('father_name')
                    ->required(),
                Forms\Components\TextInput::make('mother_name')
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('place_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('military')
                    ->required(),
                Forms\Components\TextInput::make('current_address')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                Forms\Components\TextInput::make('name_of_parent')
                    ->required(),
                Forms\Components\TextInput::make('job_of_parent')
                    ->required(),
                Forms\Components\TextInput::make('phone_of_parent')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('phone_of_mother')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('avg_mark')
                    ->required(),
                Forms\Components\TextInput::make('certificate_year')
                    ->required(),
                Forms\Components\FileUpload::make('id_image')
                    ->required(),
                Forms\Components\FileUpload::make('certificate_image')
                    ->required(),
                Forms\Components\FileUpload::make('personal_image')
                    ->required(),
                Forms\Components\FileUpload::make('un_image')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en'),
                Tables\Columns\TextColumn::make('department.name'),
                Tables\Columns\TextColumn::make('father_name'),
                Tables\Columns\TextColumn::make('mother_name'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date(),
                // Tables\Columns\TextColumn::make('place_of_birth'),
                // Tables\Columns\TextColumn::make('military'),
                // Tables\Columns\TextColumn::make('current_address'),
                Tables\Columns\TextColumn::make('address'),
                // Tables\Columns\TextColumn::make('name_of_parent'),
                // Tables\Columns\TextColumn::make('job_of_parent'),
                // Tables\Columns\TextColumn::make('phone_of_parent'),
                // Tables\Columns\TextColumn::make('phone_of_mother'),
                // Tables\Columns\TextColumn::make('avg_mark'),
                // Tables\Columns\TextColumn::make('certificate_year'),
                // Tables\Columns\TextColumn::make('id_image'),
                // Tables\Columns\TextColumn::make('certificate_image'),
                // Tables\Columns\TextColumn::make('personal_image'),
                // Tables\Columns\TextColumn::make('un_image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('accept')
                    ->action(function (AcademicRegistration $record) {
                        $record->update(['accepted' => true]);
                        if (!$record->is_department_head) {
                            $record->user->notifications()->create([
                                'title' => 'تسجيل الدخول كأستاذ',
                                'body' => 'تم قبول طلب تسجيلك كأستاذ.',
                            ]);
                        } else {
                            $record->user->notifications()->create([
                                'title' => 'تسجيل الدخول كرئيس قسم',
                                'body' => 'تم قبول طلب تسجيلك كرئيس قسم.',
                            ]);
                        }
                        $record->user->update(['role_id' => 5]);
                    }),
                Tables\Actions\Action::make('cancel')
                    ->action(function (AcademicRegistration $record) {
                        $record->update(['accepted' => false]);
                        if (!$record->is_department_head) {
                            $record->user->notifications()->create([
                                'title' => 'تسجيل الدخول كأستاذ',
                                'body' => 'نعتذر لقد تم رفض طلب تسجيل دخولك كأستاذ',
                            ]);
                        } else {
                            $record->user->notifications()->create([
                                'title' => 'تسجيل الدخول كرئيس قسم',
                                'body' => 'نعتذر لقد تم رفض طلب تسجيل دخولك كرئيس قسم',
                            ]);
                        }
                    })
                    ->color('danger'),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicRegistrations::route('/'),
            // 'create' => Pages\CreateAcademicRegistration::route('/create'),
            'view' => Pages\ViewAcademicRegistration::route('/{record}'),
            // 'edit' => Pages\EditAcademicRegistration::route('/{record}/edit'),
        ];
    }
}
