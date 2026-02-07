<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Models\ResourceItem;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Resources';

    protected static ?string $navigationGroup = 'Financial';

    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Resource Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('category')
                            ->required()
                            ->options(ResourceItem::categories())
                            ->native(false),
                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(1),
                        Forms\Components\TextInput::make('unit_cost')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('R$')
                            ->label('Unit Cost'),
                        Forms\Components\TextInput::make('total_cost')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('R$')
                            ->label('Total Cost')
                            ->disabled()
                            ->dehydrated()
                            ->helperText('Calculated automatically: quantity × unit_cost'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Dates & Status')
                    ->schema([
                        Forms\Components\DatePicker::make('purchase_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\DatePicker::make('next_maintenance_date')
                            ->nullable(),
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options(ResourceItem::statuses())
                            ->native(false)
                            ->default('active'),
                    ])
                    ->columns(3),
                
                Forms\Components\Section::make('Responsibility')
                    ->schema([
                        Forms\Components\Select::make('responsible_user_id')
                            ->label('Responsible Person')
                            ->relationship('responsibleUser', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'first_aid' => 'danger',
                        'maintenance' => 'warning',
                        'marketing' => 'info',
                        'equipment' => 'success',
                        'supplies' => 'gray',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_cost')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_cost')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        'maintenance_required' => 'warning',
                        'disposed' => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_maintenance_date')
                    ->date()
                    ->sortable()
                    ->placeholder('Not scheduled'),
                Tables\Columns\TextColumn::make('responsibleUser.name')
                    ->label('Responsible')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(ResourceItem::categories()),
                Tables\Filters\SelectFilter::make('status')
                    ->options(ResourceItem::statuses()),
                Tables\Filters\Filter::make('needs_maintenance')
                    ->query(fn (Builder $query): Builder => $query->where('next_maintenance_date', '<=', now()->addDays(30))),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
        ];
    }
}
