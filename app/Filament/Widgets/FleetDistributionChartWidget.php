<?php

namespace App\Filament\Widgets;

use App\Models\Vehicle;
use Filament\Widgets\ChartWidget;

class FleetDistributionChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Vehicle Fleet by Fuel & Propulsion';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '280px';
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $diesel = Vehicle::where('fuel_type', 'diesel')->count();
        $petrol = Vehicle::where('fuel_type', 'petrol')->count();
        $electric = Vehicle::where('fuel_type', 'electric')->count();
        $hybrid = Vehicle::where('fuel_type', 'hybrid')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Vehicles in Fleet',
                    'data' => [$diesel, $petrol, $electric, $hybrid],
                    'backgroundColor' => [
                        '#10b981', // Emerald - Diesel (4WD/Scorpio)
                        '#f59e0b', // Amber - Petrol (City/Swift)
                        '#06b6d4', // Cyan - Electric (EV)
                        '#8b5cf6', // Purple - Hybrid
                    ],
                ],
            ],
            'labels' => ['Diesel (Scorpio/HiAce)', 'Petrol (City Cars)', 'Electric (EV)', 'Hybrid'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
