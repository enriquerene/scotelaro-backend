<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModalityResource\Pages;
use App\Models\Modality;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModalityResource extends Resource
{
    protected static ?string $model = Modality::class;

    protected static ?string $navigationLabel = 'Modalities';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, $set) {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Auto-generated from name, but can be customized'),
                    Forms\Components\Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Visual Identity')
                ->schema([
                    Forms\Components\ColorPicker::make('color')
                        ->default('#3b82f6')
                        ->required(),
                    Forms\Components\Select::make('icon')
                        ->options([
                            'heroicon-o-academic-cap' => 'Academic Cap',
                            'heroicon-o-beaker' => 'Beaker',
                            'heroicon-o-bolt' => 'Bolt',
                            'heroicon-o-book-open' => 'Book Open',
                            'heroicon-o-cube' => 'Cube',
                            'heroicon-o-fire' => 'Fire',
                            'heroicon-o-globe-alt' => 'Globe',
                            'heroicon-o-heart' => 'Heart',
                            'heroicon-o-lightning-bolt' => 'Lightning Bolt',
                            'heroicon-o-musical-note' => 'Musical Note',
                            'heroicon-o-puzzle-piece' => 'Puzzle Piece',
                            'heroicon-o-shield-check' => 'Shield Check',
                            'heroicon-o-star' => 'Star',
                            'heroicon-o-trophy' => 'Trophy',
                            'heroicon-o-user-group' => 'User Group',
                        ])
                        ->searchable()
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Modality Image')
                        ->image()
                        ->directory('modalities')
                        ->maxSize(2048)
                        ->nullable()
                        ->helperText('Upload an image for this modality (max 2MB)'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->required(),
                    Forms\Components\TextInput::make('order')
                        ->numeric()
                        ->default(0)
                        ->required(),
                ])->columns(2),
        ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                Tables\Columns\ColorColumn::make('color')
                    ->label('')
                    ->width(20),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->icon ? null : 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=FFFFFF&background=3b82f6')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('classes_count')
                    ->counts('classes')
                    ->label('Classes')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                    // ->nullableLabel('All'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (Modality $record) => $record->classes()->exists()),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModalities::route('/'),
            'create' => Pages\CreateModality::route('/create'),
            'edit' => Pages\EditModality::route('/{record}/edit'),
        ];
    }
}
