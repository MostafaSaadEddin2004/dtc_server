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
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcademicStudentResource extends Resource
{
    protected static ?string $model = AcademicStudent::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    protected static ?string $navigationGroup = 'Academic';

    protected static ?string $pluralModelLabel = 'Students';

    protected static ?string $modelLabel = 'Student';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en'),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Class'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                Action::make('View data')
                    ->url(fn (AcademicStudent $record): string => route('filament.resources.academic-registrations.view', $record->user->registeration->id)),
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
