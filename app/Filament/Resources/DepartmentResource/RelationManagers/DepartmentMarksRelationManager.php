<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use App\Models\Department;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentMarksRelationManager extends RelationManager
{
    protected static string $relationship = 'departmentMarks';

    protected static ?string $recordTitleAttribute = 'mark';

    protected static ?string $label = 'Mark';
    // protected static ?string $modelLabel = 'department';
    protected static ?string $pluralModelLabel = 'Mark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('mark')
                    ->required()
                    ->integer()
                    ->maxValue(100)
                    ->minValue(0),
                TextInput::make('year')
                    ->integer()
                    ->maxValue(2050)
                    ->minValue(2023)
                    ->required(),
                Select::make('certificate_type_id')
                    ->relationship('certificateType', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mark'),
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('certificateType.name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
