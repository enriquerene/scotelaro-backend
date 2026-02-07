<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationLabel = 'Enrollments';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Contract Details')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Select::make('pricing_tier_id')
                        ->relationship('pricingTier', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('amount')
                        ->numeric()
                        ->required()
                        ->prefix('R$'),
                    Forms\Components\Select::make('payment_method')
                        ->options([
                            'credit_card' => 'Credit Card',
                            'debit_card' => 'Debit Card',
                            'cash' => 'Cash',
                            'pix' => 'PIX',
                            'bank_transfer' => 'Bank Transfer',
                        ])
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Class Assignment')
                ->schema([
                    Forms\Components\Select::make('class_id')
                        ->relationship('gymClass', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\DateTimePicker::make('enrolled_at')
                        ->default(now()),
                    Forms\Components\DateTimePicker::make('next_billing_date')
                        ->default(now()->addMonth()),
                ])->columns(3),

            Forms\Components\Section::make('Status')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'pending' => 'Pending',
                            'overdue' => 'Overdue',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('active')
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pricingTier.name')
                    ->label('Plan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'overdue' => 'danger',
                        'cancelled' => 'gray',
                        default => 'warning',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('next_billing_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'pending' => 'Pending',
                        'overdue' => 'Overdue',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'credit_card' => 'Credit Card',
                        'debit_card' => 'Debit Card',
                        'cash' => 'Cash',
                        'pix' => 'PIX',
                        'bank_transfer' => 'Bank Transfer',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('cancel')
                    ->label('Deactivate')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Cancel Enrollment')
                    ->modalDescription('This will cancel the enrollment. The student will no longer have access to the class.')
                    ->form([
                        Forms\Components\Select::make('cancellation_reason')
                            ->options([
                                'user_request' => 'User Requested',
                                'medical' => 'Medical/Injury',
                                'payment_issue' => 'Payment Default',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Additional Notes')
                            ->rows(3),
                    ])
                    ->action(function (Enrollment $record, array $data) {
                        $record->update([
                            'status' => 'cancelled',
                            'cancellation_reason' => $data['cancellation_reason'],
                            'cancelled_at' => now(),
                            'notes' => $record->notes . "\nCancelled: " . $data['cancellation_reason'] . "\n" . ($data['notes'] ?? ''),
                        ]);

                        Notification::make()
                            ->title('Enrollment Cancelled')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Enrollment $record) => $record->isActive()),

                Tables\Actions\Action::make('renew')
                    ->label('Manual Renew')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Manual Renewal')
                    ->modalDescription('Extend the next billing date by the plan\'s billing period.')
                    ->action(function (Enrollment $record) {
                        $record->update([
                            'next_billing_date' => $record->next_billing_date->addMonth(),
                            'notes' => $record->notes . "\nManually renewed on " . now()->format('Y-m-d'),
                        ]);

                        Notification::make()
                            ->title('Enrollment Renewed')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Enrollment $record) => $record->isActive() && auth()->user()->isAdmin()),

                Tables\Actions\Action::make('changePaymentMethod')
                    ->label('Change Payment')
                    ->icon('heroicon-o-credit-card')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'credit_card' => 'Credit Card',
                                'debit_card' => 'Debit Card',
                                'cash' => 'Cash',
                                'pix' => 'PIX',
                                'bank_transfer' => 'Bank Transfer',
                            ])
                            ->required(),
                    ])
                    ->action(function (Enrollment $record, array $data) {
                        $record->update([
                            'payment_method' => $data['payment_method'],
                            'notes' => $record->notes . "\nPayment method changed to " . $data['payment_method'] . " on " . now()->format('Y-m-d'),
                        ]);

                        Notification::make()
                            ->title('Payment Method Updated')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Enrollment $record) => $record->isActive()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Student Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Student Name'),
                        Infolists\Components\TextEntry::make('user.phone')
                            ->label('Phone'),
                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email'),
                    ])->columns(3),

                Infolists\Components\Section::make('Contract Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('pricingTier.name')
                            ->label('Plan'),
                        Infolists\Components\TextEntry::make('amount')
                            ->money('BRL')
                            ->label('Original Price'),
                        Infolists\Components\TextEntry::make('enrolled_at')
                            ->dateTime()
                            ->label('Enrollment Date'),
                    ])->columns(3),

                Infolists\Components\Section::make('Billing Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('payment_method')
                            ->label('Payment Method')
                            ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                        Infolists\Components\TextEntry::make('next_billing_date')
                            ->dateTime()
                            ->label('Next Billing Date'),
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'overdue' => 'danger',
                                'cancelled' => 'gray',
                                default => 'warning',
                            }),
                    ])->columns(3),

                Infolists\Components\Section::make('Class Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('gymClass.name')
                            ->label('Class'),
                        Infolists\Components\TextEntry::make('gymClass.modality.name')
                            ->label('Modality'),
                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Created At'),
                    ])->columns(3),

                Infolists\Components\Section::make('Notes')
                    ->schema([
                        Infolists\Components\TextEntry::make('notes')
                            ->columnSpanFull()
                            ->markdown(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'view' => Pages\ViewEnrollment::route('/{record}'),
            // Edit page removed for strict "no-edit" strategy
            // 'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
