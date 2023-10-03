<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademicRegistrationResource\Pages;
use App\Filament\Resources\AcademicRegistrationResource\RelationManagers\WishesRelationManager;
use App\Models\AcademicRegistration;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Valuestore\Valuestore;

class AcademicRegistrationResource extends Resource
{
    protected static ?string $model = AcademicRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic';

    public static function getEloquentQuery(): Builder
    {
        $builder = parent::getEloquentQuery()->withoutGlobalScopes();
        if (request()->routeIs('filament.resources.academic-registrations.view')) {
            return $builder;
        }
        return $builder->whereNull('accepted');
    }

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('accepted')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'first_name_en')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('father_name')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('mother_name')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('place_of_birth')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('military')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('current_address')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('name_of_parent')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('job_of_parent')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('phone_of_parent')
                    ->tel()
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('phone_of_mother')
                    ->tel()
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('avg_mark')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('certificate_year')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\FileUpload::make('id_image')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\FileUpload::make('certificate_image')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\FileUpload::make('personal_image')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\FileUpload::make('un_image')
                    ->required()
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('department_id')
                ->label('Class')
                    ->relationship('department', 'name', fn (Builder $query) => request()->routeIs('filament.resources.academic-registrations.view') ? $query : $query->whereHas('wishes', fn (Builder $q) => $q->where('academic_registration_id', request()->record)))
                    ->nullable(),
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
                    ->label('Class')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('father_name'),
                // Tables\Columns\TextColumn::make('mother_name'),
                // Tables\Columns\TextColumn::make('date_of_birth')
                //     ->date(),
                // Tables\Columns\TextColumn::make('place_of_birth'),
                // Tables\Columns\TextColumn::make('military'),
                // Tables\Columns\TextColumn::make('current_address'),
                Tables\Columns\TextColumn::make('address'),
                // Tables\Columns\TextColumn::make('name_of_parent'),
                // Tables\Columns\TextColumn::make('job_of_parent'),
                // Tables\Columns\TextColumn::make('phone_of_parent'),
                // Tables\Columns\TextColumn::make('phone_of_mother'),
                Tables\Columns\TextColumn::make('avg_mark')
                ->label('Mark')
                ->sortable(),
                // Tables\Columns\TextColumn::make('certificate_year'),
                // Tables\Columns\TextColumn::make('id_image'),
                // Tables\Columns\TextColumn::make('certificate_image'),
                // Tables\Columns\TextColumn::make('personal_image'),
                // Tables\Columns\TextColumn::make('un_image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name')
                    ->label('Class')
                    ->searchable()
                    ->multiple(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('accept')
                    ->action(function (AcademicRegistration $record) {
                        $valueStore = ValueStore::make(config('filament-settings.path'));
                        $record->update(['accepted' => true]);
                        $record->user->notifications()->create([
                            'title' => 'تسجيل الدخول',
                            'body' => 'تم قبول طلب تسجيلك بدورة ' . $record->department->name .'. يرجى القدوم في تاريخ ' . Carbon::parse($valueStore->get('interview_at'))->toDateString() . ' لعمل مقابلة.',
                        ]);
                        $record->user->update(['role_id' => 4]);
                        $record->department->students()->create(['user_id' => $record->user->id]);
                    }),
                Tables\Actions\Action::make('cancel')
                    ->action(function (AcademicRegistration $record) {
                        $record->update(['accepted' => false]);
                        $record->user->notifications()->create([
                            'title' => 'تسجيل الدخول كطالب',
                            'body' => 'تم قبول طلب تسجيلك كطالب.',
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
            WishesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicRegistrations::route('/'),
            // 'create' => Pages\CreateAcademicRegistration::route('/create'),
            'view' => Pages\ViewAcademicRegistration::route('/{record}'),
            'edit' => Pages\EditAcademicRegistration::route('/{record}/edit'),
        ];
    }
}
