<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DriverProfile;
use App\Models\OutboundClick;
use App\Models\Search;
use App\Models\Subscriber;
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
        $totalRevenue = Booking::whereNotIn('status', ['cancelled'])->sum('total_price');
        $openTickets = ContactMessage::where('status', 'new')->count();
        $activeSubscribers = Subscriber::where('status', 'active')->count();

        return [
            Stat::make('Gross Reservation Revenue', 'Rs. ' . number_format($totalRevenue))
                ->description('Total active booking volume')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([45, 62, 58, 75, 90, 84, 110])
                ->color('success'),

            Stat::make('Direct Bookings', number_format($directBookings))
                ->description('Direct reservations on Hahakar')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart([4, 6, 8, 10, 7, 12, 15])
                ->color('emerald'),

            Stat::make('Partner Drivers & Fleets', number_format($verifiedDrivers))
                ->description($pendingDrivers > 0 ? "{$pendingDrivers} pending verification" : 'All partners verified')
                ->descriptionIcon('heroicon-m-identification')
                ->color($pendingDrivers > 0 ? 'warning' : 'primary'),

            Stat::make('Active Fleet Vehicles', number_format($activeVehicles))
                ->description('Scorpio 4WD, HiAce, Hilux & City cars')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Newsletter Subscribers', number_format($activeSubscribers))
                ->description('Active marketing audience')
                ->descriptionIcon('heroicon-m-envelope-open')
                ->chart([12, 18, 25, 30, 42, 55, 70])
                ->color('primary'),

            Stat::make('Support Desk Queue', number_format($openTickets))
                ->description($openTickets > 0 ? "{$openTickets} tickets need response" : 'All customer inquiries resolved')
                ->descriptionIcon('heroicon-m-inbox')
                ->color($openTickets > 0 ? 'danger' : 'gray'),
        ];
    }
}
