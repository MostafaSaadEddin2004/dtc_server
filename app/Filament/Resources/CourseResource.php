<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Course';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Tabs::make('Course')
                        ->tabs([
                            Tab::make('Course Info')->schema([
                                TextInput::make('name')
                                    ->required(),
                                DatePicker::make('registration_start_at')
                                    ->required(),
                                DatePicker::make('registration_end_at')
                                    ->required(),
                            ]),
                            Tab::make('Post Info')->schema([
                                Textarea::make('content')
                                    ->label('Post content')
                                    ->required(),
                                FileUpload::make('attachment')
                                    ->label('Post attachment')
                                    ->disk('public')
                                    ->nullable(),
                            ]),
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('registration_start_at')->date(),
                TextColumn::make('registration_end_at')->date(),
                TextColumn::make('post.content')
                    ->searchable()
                    ->sortable()
                    ->limit(25),
                //TODO:: handle attachment view
                ImageColumn::make('post.attachment')
                    ->label('Attachment')
                    ->defaultImageUrl(url('/logo.png')),
                TextColumn::make('created_at')->since(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('Show students')
                    ->icon('heroicon-o-user-group')
                    ->color('warning')
                    ->url(fn (Course $record) => route('filament.resources.course-students.index') . '?tableFilters[course][values][0]=' . $record->id),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
