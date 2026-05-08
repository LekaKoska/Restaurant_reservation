<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReservationStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

                 Stat::make('All active Reservations', Reservation::where('is_active', true)->count())
                     ->description('All reservations with active status')
                     ->color('success')

           ];
    }
}
