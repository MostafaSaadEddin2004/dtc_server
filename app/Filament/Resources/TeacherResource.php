<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        $builder = parent::getEloquentQuery()->withoutGlobalScopes();
        if (request()->routeIs('filament.resources.teacher-registrations.view')) {
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
                Forms\Components\TextInput::make('certificate')
                    ->required(),
                Forms\Components\TextInput::make('specialty')
                    ->required(),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\TextInput::make('current_location')
                    ->required(),
                Forms\Components\TextInput::make('permanent_location')
                    ->required(),
                Forms\Components\TextInput::make('nationality')
                    ->required(),
                Forms\Components\Toggle::make('is_department_head')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_department_head')->boolean(),
                // Tables\Columns\TextColumn::make('certificate'),
                // Tables\Columns\TextColumn::make('specialty'),
                // Tables\Columns\TextColumn::make('birth_date')
                //     ->date(),
                // Tables\Columns\TextColumn::make('current_location'),
                // Tables\Columns\TextColumn::make('permanent_location'),
                // Tables\Columns\TextColumn::make('nationality'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                TernaryFilter::make('is_department_head')
                    ->label('Teacher Type')
                    ->attribute('is_department_head')
                    ->trueLabel('Department Head')
                    ->falseLabel('Teacher'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('accept')
                    ->action(function (Teacher $record) {
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
                    ->action(function (Teacher $record) {
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
            'index' => Pages\ListTeachers::route('/'),
            // 'create' => Pages\CreateTeacher::route('/create'),
            // 'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}