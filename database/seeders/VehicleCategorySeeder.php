<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['code' => 'MINI', 'name' => 'Mini', 'sipp_code' => 'MBMN', 'default_seats' => 4, 'default_bags' => 1, 'default_doors' => 3, 'sort_order' => 1],
            ['code' => 'ECONOMY', 'name' => 'Economy', 'sipp_code' => 'EDMR', 'default_seats' => 5, 'default_bags' => 2, 'default_doors' => 4, 'sort_order' => 2],
            ['code' => 'COMPACT', 'name' => 'Compact', 'sipp_code' => 'CDAR', 'default_seats' => 5, 'default_bags' => 2, 'default_doors' => 4, 'sort_order' => 3],
            ['code' => 'INTERMEDIATE', 'name' => 'Intermediate', 'sipp_code' => 'IDAR', 'default_seats' => 5, 'default_bags' => 3, 'default_doors' => 4, 'sort_order' => 4],
            ['code' => 'STANDARD', 'name' => 'Standard', 'sipp_code' => 'SDAR', 'default_seats' => 5, 'default_bags' => 3, 'default_doors' => 4, 'sort_order' => 5],
            ['code' => 'FULLSIZE', 'name' => 'Full Size', 'sipp_code' => 'FDAR', 'default_seats' => 5, 'default_bags' => 4, 'default_doors' => 4, 'sort_order' => 6],
            ['code' => 'SUV', 'name' => 'SUV', 'sipp_code' => 'IFAR', 'default_seats' => 5, 'default_bags' => 3, 'default_doors' => 5, 'sort_order' => 7],
            ['code' => 'VAN', 'name' => 'Passenger Van', 'sipp_code' => 'FVAR', 'default_seats' => 8, 'default_bags' => 5, 'default_doors' => 4, 'sort_order' => 8],
            ['code' => 'LUXURY', 'name' => 'Luxury / Premium', 'sipp_code' => 'PDAR', 'default_seats' => 5, 'default_bags' => 3, 'default_doors' => 4, 'sort_order' => 9],
        ];

        foreach ($categories as $cat) {
            VehicleCategory::updateOrCreate(
                ['code' => $cat['code']],
                array_merge($cat, ['is_active' => true])
            );
        }
    }
}
