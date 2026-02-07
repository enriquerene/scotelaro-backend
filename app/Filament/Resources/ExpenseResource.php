<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Models\Expense;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form as FilamentForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationLabel = 'Outcomes';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-down';

    protected static ?string $navigationGroup = 'Financial';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Expense Details')
                ->schema([
                    Forms\Components\TextInput::make('description')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->required()
                        ->prefix('R$')
                        ->rules(['min:0']),
                    Forms\Components\Select::make('category')
                        ->options(Expense::categories())
                        ->required()
                        ->default(Expense::CATEGORY_OTHER),
                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->default(now()),
                    Forms\Components\Select::make('payment_method')
                        ->options(Expense::paymentMethods())
                        ->required()
                        ->default(Expense::PAYMENT_METHOD_CASH),
                ])->columns(2),

            Forms\Components\Section::make('Additional Information')
                ->schema([
                    Forms\Components\Select::make('staff_id')
                        ->label('Staff Member (if staff payment)')
                        ->options(User::whereIn('role', ['staff', 'admin'])->pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),
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
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('amount')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->formatStateUsing(fn (string $state): string => Expense::categories()[$state] ?? $state)
                    ->colors([
                        'warning' => Expense::CATEGORY_STAFF_PAYMENT,
                        'info' => Expense::CATEGORY_MAINTENANCE,
                        'success' => Expense::CATEGORY_MARKETING,
                        'gray' => Expense::CATEGORY_OTHER,
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label('Staff Member')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(Expense::categories()),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(Expense::paymentMethods()),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
