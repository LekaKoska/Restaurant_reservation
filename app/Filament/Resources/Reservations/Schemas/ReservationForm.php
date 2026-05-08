<?php

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('table_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('guest_number')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('start_date')
                    ->required(),
                DateTimePicker::make('end_date'),
                TextInput::make('special_request'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
