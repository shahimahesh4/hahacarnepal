<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DriverProfile;
use App\Models\OutboundClick;
use App\Models\PriceAlert;
use App\Models\Search;
use App\Models\Vehicle;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $searchCount = Search::count();
        $clickCount = OutboundClick::count();
        $ctr = $searchCount > 0 ? round(($clickCount / $searchCount) * 100, 1) : 0.0;
        $pendingDrivers = DriverProfile::where('status', 'pending')->count();
        $verifiedDrivers = DriverProfile::where('status', 'verified')->count();
        $activeVehicles = Vehicle::where('is_active', true)->count();
        $directBookings = Booking::count();
        $openTickets = ContactMessage::where('status', 'new')->count();

        return [
            Stat::make('Direct Bookings', number_format($directBookings))
                ->description('Direct reservations on Hahacar')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('Partner Drivers & Owners', number_format($verifiedDrivers))
                ->description($pendingDrivers > 0 ? "{$pendingDrivers} pending verification" : 'All partners verified')
                ->descriptionIcon('heroicon-m-identification')
                ->color($pendingDrivers > 0 ? 'warning' : 'primary'),

            Stat::make('Active Fleet Vehicles', number_format($activeVehicles))
                ->description('Scorpio, Hilux, Creta, HiAce & Swift')
                ->descriptionIcon('heroicon-m-truck')
                ->color('emerald'),

            Stat::make('Total Searches', number_format($searchCount))
                ->description('Aggregator & rental queries')
                ->descriptionIcon('heroicon-m-magnifying-glass')
                ->color('primary'),

            Stat::make('Outbound Clicks & CTR', number_format($clickCount) . " ({$ctr}%)")
                ->description('Partner affiliate referrals')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('info'),

            Stat::make('Pending Support Tickets', number_format($openTickets))
                ->description('Customer care queue')
                ->descriptionIcon('heroicon-m-inbox')
                ->color($openTickets > 0 ? 'danger' : 'gray'),
        ];
    }
}
