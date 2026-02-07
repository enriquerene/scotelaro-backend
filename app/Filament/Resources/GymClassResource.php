<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GymClassResource\Pages;
use App\Models\GymClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;

class GymClassResource extends Resource
{
    protected static ?string $model = GymClass::class;

    protected static ?string $navigationLabel = 'Classes';

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Select::make('modality_id')->relationship('modality','name')->required(),
            Forms\Components\Select::make('instructor_id')->relationship('instructor','name')->preload()->nullable(),
            Forms\Components\TextInput::make('capacity')->numeric(),
            Forms\Components\Textarea::make('schedule')->rows(3),
        ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('modality.name')->label('Modality')->sortable(),
            Tables\Columns\TextColumn::make('instructor.name')->label('Instructor')->sortable(),
            Tables\Columns\TextColumn::make('capacity')->sortable(),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGymClasses::route('/'),
            'create' => Pages\CreateGymClass::route('/create'),
            'edit' => Pages\EditGymClass::route('/{record}/edit'),
        ];
    }
}
