<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseStudentResource\Pages;
use App\Filament\Resources\CourseStudentResource\RelationManagers;
use App\Models\CourseStudent;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;

class CourseStudentResource extends Resource
{
    protected static ?string $model = CourseStudent::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    protected static ?string $navigationGroup = 'Course';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'first_name_en')
                    ->required(),
                Forms\Components\Select::make('course_id')
                    ->relationship('course', 'name')
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
                Tables\Columns\TextColumn::make('course.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('course')
                    ->relationship('course', 'name')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                Action::make('View data')
                    ->url(fn (CourseStudent $record): string => route('filament.resources.course-registrations.view', $record->user->courseRegisteration()->where('course_id', $record->course->id)->first())),
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
            'index' => Pages\ListCourseStudents::route('/'),
            // 'create' => Pages\CreateCourseStudent::route('/create'),
            // 'edit' => Pages\EditCourseStudent::route('/{record}/edit'),
        ];
    }
}
