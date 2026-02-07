<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingTierResource\Pages;
use App\Models\PricingTier;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PricingTierResource extends Resource
{
    protected static ?string $model = PricingTier::class;

    protected static ?string $navigationLabel = 'Pricing Tiers';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\MarkdownEditor::make('description')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Financials')
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->required()
                        ->prefix('R$')
                        ->rules(['min:0']),
                    Forms\Components\TextInput::make('comparative_price')
                        ->label('Comparative Price (Strikethrough)')
                        ->numeric()
                        ->prefix('R$')
                        ->rules(['min:0', 'nullable'])
                        ->helperText('Original price to show as strikethrough for promotions'),
                    Forms\Components\Select::make('billing_period')
                        ->options([
                            'monthly' => 'Monthly',
                            'quarterly' => 'Quarterly',
                            'yearly' => 'Yearly',
                        ])
                        ->default('monthly')
                        ->required(),
                ])->columns(3),

            Forms\Components\Section::make('Limits')
                ->schema([
                    Forms\Components\Radio::make('frequency_type')
                        ->options([
                            'unlimited' => 'Unlimited',
                            'fixed' => 'Fixed Amount',
                        ])
                        ->default('unlimited')
                        ->required()
                        ->live(),
                    Forms\Components\TextInput::make('class_cap')
                        ->label('Class Cap (per week)')
                        ->numeric()
                        ->minValue(1)
                        ->required(fn (Forms\Get $get): bool => $get('frequency_type') === 'fixed')
                        ->hidden(fn (Forms\Get $get): bool => $get('frequency_type') !== 'fixed'),
                    Forms\Components\TextInput::make('class_count')
                        ->label('Default Class Count')
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Scope')
                ->schema([
                    Forms\Components\CheckboxList::make('modalities')
                        ->relationship('modalities', 'name')
                        ->searchable()
                        ->columns(2)
                        ->helperText('Select which modalities this plan applies to'),
                ]),

            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->required(),
                    Forms\Components\Textarea::make('notes')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('billing_period')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'monthly' => 'info',
                        'quarterly' => 'warning',
                        'yearly' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('class_count')
                    ->label('Credits')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subscriptions_count')
                    ->counts('subscriptions')
                    ->label('Active Subs')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\SelectFilter::make('billing_period')
                    ->options([
                        'monthly' => 'Monthly',
                        'quarterly' => 'Quarterly',
                        'yearly' => 'Yearly',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (PricingTier $record) => $record->hasActiveSubscriptions()),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('archive')
                    ->label('Archive')
                    ->icon('heroicon-o-archive-box')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Archive Pricing Tier')
                    ->modalDescription('This will mark the pricing tier as inactive.')
                    ->action(function (PricingTier $record) {
                        $record->update(['is_active' => false]);
                    })
                    ->hidden(fn (PricingTier $record) => !$record->is_active),
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
            'index' => Pages\ListPricingTiers::route('/'),
            'create' => Pages\CreatePricingTier::route('/create'),
            'edit' => Pages\EditPricingTier::route('/{record}/edit'),
        ];
    }
}
