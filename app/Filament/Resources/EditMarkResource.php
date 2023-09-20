<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EditMarkResource\Pages;
use App\Models\EditMark;
use App\Models\Teacher;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Contracts\Database\Query\Builder;

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
                Textarea::make("reason"),
                Select::make("teacher_id")
                    ->relationship('teacher', 'user_id')
                    ->getOptionLabelFromRecordUsing(fn (Teacher $record) => "{$record->name}"),
                Select::make("user_id")
                    ->relationship('user', 'first_name_en'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("teacher.name")
                    ->searchable()
                    ->sortable()
                    ->label('Teacher'),
                TextColumn::make("user.first_name_en")
                    ->searchable()
                    ->sortable(),
                TextColumn::make("subject")->searchable()
                    ->sortable(),
                TextColumn::make("mark"),
                TextColumn::make("reason")->limit(25),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make('view'),
                //TODO:: make the correct logic for this action
                Action::make('accept')
                    ->action(fn (EditMark $record) => $record->delete()),
                //TODO:: make the correct logic for this action
                    Action::make('cancel')
                    ->action(fn (EditMark $record) => $record->delete())
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