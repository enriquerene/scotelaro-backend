<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Students';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Users';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->required()
                        ->maxLength(40)
                        ->tel(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                ])->columns(2),

            Forms\Components\Section::make('Account Settings')
                ->schema([
                    Forms\Components\Select::make('role')
                        ->options([
                            'student' => 'Student',
                            'staff' => 'Staff',
                            'admin' => 'Admin',
                        ])
                        ->default('student')
                        ->required()
                        ->visible(fn (): bool => auth()->user()->isAdmin()),
                    Forms\Components\Toggle::make('email_verified_at')
                        ->label('Email Verified')
                        ->default(true)
                        ->dehydrated(false)
                        ->afterStateHydrated(function ($component, $state) {
                            $component->state(!is_null($state));
                        })
                        ->dehydrateStateUsing(fn ($state) => $state ? now() : null),
                ]),
        ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'staff' => 'warning',
                        'student' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->counts('enrollments')
                    ->label('Enrollments')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'student' => 'Student',
                        'staff' => 'Staff',
                        'admin' => 'Admin',
                    ])
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn (): bool => auth()->user()->isAdmin()),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            // Admin sees all users with student role or enrolled students
            return parent::getEloquentQuery()
                ->where(function ($query) {
                    $query->where('role', 'student')
                        ->orWhereHas('enrollments');
                });
        }
        
        if ($user->isStaff()) {
            // Staff sees students who have at least one check-in in a class taught by this instructor
            // OR students currently enrolled in modalities the instructor teaches
            return parent::getEloquentQuery()
                ->where('role', 'student')
                ->whereHas('enrollments', function ($q) use ($user) {
                    $q->whereHas('gymClass', function ($q2) use ($user) {
                        $q2->where('instructor_id', $user->id);
                    });
                });
        }
        
        // Default: only students
        return parent::getEloquentQuery()->where('role', 'student');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
