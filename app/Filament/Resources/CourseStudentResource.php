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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseStudentResource extends Resource
{
    protected static ?string $model = CourseStudent::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
                    ->multiple(),
            ])
            ->actions([])
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
