<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseRegistrationResource\Pages;
use App\Models\CourseRegistration;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class CourseRegistrationResource extends Resource
{
    protected static ?string $model = CourseRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getEloquentQuery(): Builder
    {
        $builder = parent::getEloquentQuery()->withoutGlobalScopes();
        if (request()->routeIs('filament.resources.course-registrations.view')) {
            return $builder;
        }
        return $builder->whereNull('accepted');
    }

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
                Forms\Components\Toggle::make('is_male')
                    ->required(),
                Forms\Components\TextInput::make('social_status')
                    ->required(),
                Forms\Components\TextInput::make('nationality')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required(),
                Forms\Components\TextInput::make('student_type')
                    ->required(),
                Forms\Components\TextInput::make('work_type')
                    ->required(),
                Forms\Components\Toggle::make('is_morning')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.first_name_en')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('course.name')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_male')
                    ->boolean(),
                // Tables\Columns\TextColumn::make('social_status'),
                // Tables\Columns\TextColumn::make('nationality'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date(),
                // Tables\Columns\TextColumn::make('student_type'),
                // Tables\Columns\TextColumn::make('work_type'),
                Tables\Columns\IconColumn::make('is_morning')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                TernaryFilter::make('is_male')
                    ->label('Gender')
                    ->trueLabel('Male')
                    ->falseLabel('Female'),
                TernaryFilter::make('is_morning')
                    ->label('Time')
                    ->trueLabel('Morning')
                    ->falseLabel('Evening'),
                SelectFilter::make('student_type')
                    ->multiple()
                    ->options([
                        'طالب في المعهد' => 'طالب في المعهد',
                        'طالب متخرج من المعهد' => 'طالب متخرج من المعهد',
                        'طالب جامعي' => 'طالب جامعي',
                        'طالب جامعي متخرج' => 'طالب جامعي متخرج',
                    ]),
                SelectFilter::make('work_type')
                    ->multiple()
                    ->options([
                        'إعمال حرة' => 'إعمال حرة',
                        'عمل بدوام جزئي' => 'عمل بدوام جزئي',
                        'عمل بدوام كامل' => 'عمل بدوام كامل',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                //TODO:: make the correct logic for this action
                Action::make('accept')
                    ->action(function (CourseRegistration $record) {
                        $record->update(['accepted' => true]);
                        $record->course->students()->create(['user_id' => $record->user->id]);
                        $record->user->notifications()->create([
                            'title' => 'طلب التسجيل على الدورة القصيرة',
                            'body' => 'تم قبول انتسابك الى الدورة ' . $record->course->name . ' بنجاح . يرجى التواصل مع الإدارة.',
                        ]);
                    }),
                //TODO:: make the correct logic for this action
                Action::make('cancel')
                    ->action(function (CourseRegistration $record) {
                        $record->update(['accepted' => false]);
                        $record->user->notifications()->create([
                            'title' => 'طلب التسجيل على الدورة القصيرة',
                            'body' => 'نعتذر لقد تم رفض طلب انتسابك الى الدورة ' . $record->course->name . '.',
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
            'index' => Pages\ListCourseRegistrations::route('/'),
            'view' => Pages\ViewCourseRegistration::route('/{record}'),
            // 'create' => Pages\CreateCourseRegistration::route('/create'),
            // 'edit' => Pages\EditCourseRegistration::route('/{record}/edit'),
        ];
    }
}
