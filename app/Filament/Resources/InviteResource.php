<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InviteResource\Pages;
use App\Models\Invite;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form as FilamentForm;
use Filament\Tables\Table as FilamentTable;

class InviteResource extends Resource
{
    protected static ?string $model = Invite::class;

    protected static ?string $navigationLabel = 'Invites';

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Users';

    public static function form(FilamentForm $form): FilamentForm
    {
        return $form->schema([
            Forms\Components\Section::make('Invite Details')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->required()
                        ->maxLength(40)
                        ->tel()
                        ->helperText('Phone number to send the invite to'),
                    Forms\Components\Select::make('role')
                        ->label('Invite for')
                        ->options([
                            'student' => 'Student',
                            'staff' => 'Staff/Instructor',
                            'admin' => 'Administrator',
                        ])
                        ->default('student')
                        ->required()
                        ->helperText('Select the role for the invited user'),
                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('Expiration Date')
                        ->helperText('Leave empty for no expiration'),
                ])->columns(2),
        ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('phone')
                ->searchable()
                ->sortable(),
            Tables\Columns\BadgeColumn::make('role')
                ->formatStateUsing(fn (string $state): string => ucfirst($state))
                ->colors([
                    'success' => 'student',
                    'warning' => 'staff',
                    'danger' => 'admin',
                ])
                ->sortable(),
            Tables\Columns\TextColumn::make('expires_at')
                ->dateTime()
                ->sortable()
                ->placeholder('Never'),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvites::route('/'),
            'create' => Pages\CreateInvite::route('/create'),
            'edit' => Pages\EditInvite::route('/{record}/edit'),
        ];
    }
}
