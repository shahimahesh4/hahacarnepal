<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class BookingRevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Monthly Bookings & Revenue Trend (NPR)';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            return Carbon::now()->subMonths($monthsAgo);
        });

        $labels = $months->map(fn ($date) => $date->format('M Y'))->toArray();

        $bookingCounts = $months->map(function ($date) {
            return Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        })->toArray();

        $revenues = $months->map(function ($date) {
            return (int) round(Booking::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereNotIn('status', ['cancelled'])
                ->sum('total_price') / 1000); // In thousands of NPR
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Direct Bookings',
                    'data' => $bookingCounts,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Revenue (Rs. in Thousands)',
                    'data' => $revenues,
                    'borderColor' => '#38bdf8',
                    'backgroundColor' => 'rgba(56, 189, 248, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
