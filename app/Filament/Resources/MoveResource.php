<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoveResource\Pages;
use App\Models\Move;
use App\Models\Notification;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class MoveResource extends Resource
{
    protected static ?string $model = Move::class;

    protected static ?string $navigationIcon = 'fas-move';

    protected static ?string $navigationGroup = 'Student Requests';

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
                Forms\Components\Textarea::make('text')
                    ->required(),
                Forms\Components\Select::make('department')
                    ->relationship('user', 'name')
                    ->label('Current Department')
                    ->getOptionLabelFromRecordUsing(fn (User $record) => "{$record->department?->name}"),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en'),
                Tables\Columns\TextColumn::make('user.department.name')->label('Current Class'),
                Tables\Columns\TextColumn::make('department.name')->label('Class to move to'),
                Tables\Columns\TextColumn::make('text'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                //TODO:: make the correct logic for this action
                Action::make('accept')
                    ->action(function (Move $record) {
                        $record->delete();
                        $record->user->notifications()->create([
                            'title' => 'طلب الانتقال',
                            'body' => 'تم قبول طلبك بنجاح. يرجى التواصل مع الإدارة.',
                        ]);
                    }),
                //TODO:: make the correct logic for this action
                Action::make('cancel')
                    ->action(function (Move $record) {
                        $record->delete();
                        $record->user->notifications()->create([
                            'title' => 'طلب الانتقال',
                            'body' => 'نعتذر لقد تم رفض طلبك.',
                        ]);
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
            'index' => Pages\ListMoves::route('/'),
            // 'create' => Pages\CreateMove::route('/create'),
            // 'edit' => Pages\EditMove::route('/{record}/edit'),
        ];
    }
}
