<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EditMarkResource\Pages;
use App\Filament\Resources\EditMarkResource\RelationManagers;
use App\Models\EditMark;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EditMarkResource extends Resource
{
    protected static ?string $model = EditMark::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("subject"),
                TextInput::make("mark"),
                TextInput::make("reason"),
                TextInput::make("teacher"),
                Select::make("user_id")
                    ->relationship('user', 'first_name_en'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make("subject"),
                // TextColumn::make("mark"),
                // TextColumn::make("reason"),
                TextColumn::make("teacher"),
                TextColumn::make("user.first_name_en"),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make()
                    ->action()
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
            'index' => Pages\ListEditMarks::route('/'),
            // 'create' => Pages\CreateEditMark::route('/create'),
            // 'edit' => Pages\EditEditMark::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
