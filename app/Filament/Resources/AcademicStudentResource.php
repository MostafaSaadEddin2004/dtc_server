<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicStudentResource\Pages;
use App\Filament\Resources\AcademicStudentResource\RelationManagers;
use App\Models\AcademicStudent;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcademicStudentResource extends Resource
{
    protected static ?string $model = AcademicStudent::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en'),
                Tables\Columns\TextColumn::make('department.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAcademicStudents::route('/'),
            // 'create' => Pages\CreateAcademicStudent::route('/create'),
            // 'view' => Pages\ViewAcademicStudent::route('/{record}'),
            // 'edit' => Pages\EditAcademicStudent::route('/{record}/edit'),
        ];
    }
}