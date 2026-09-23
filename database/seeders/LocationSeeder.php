<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Tribhuvan International Airport',
                'type' => 'airport',
                'iata_code' => 'KTM',
                'city' => 'Kathmandu',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.6966,
                'longitude' => 85.3591,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Thamel Tourist Hub',
                'type' => 'city',
                'iata_code' => 'THM',
                'city' => 'Kathmandu',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.7154,
                'longitude' => 85.3123,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Kalanki Transit Terminal',
                'type' => 'city',
                'iata_code' => 'KLN',
                'city' => 'Kathmandu',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.6934,
                'longitude' => 85.2816,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Pokhara International Airport',
                'type' => 'airport',
                'iata_code' => 'PKR',
                'city' => 'Pokhara',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 28.2009,
                'longitude' => 83.9821,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Lakeside Tourist Hub',
                'type' => 'city',
                'iata_code' => 'LKS',
                'city' => 'Pokhara',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 28.2096,
                'longitude' => 83.9585,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Bharatpur Airport (Chitwan)',
                'type' => 'airport',
                'iata_code' => 'BHR',
                'city' => 'Chitwan',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.6775,
                'longitude' => 84.4297,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Sauraha Jungle Center',
                'type' => 'city',
                'iata_code' => 'SRH',
                'city' => 'Chitwan',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.5833,
                'longitude' => 84.4983,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Gautam Buddha International Airport',
                'type' => 'airport',
                'iata_code' => 'BWA',
                'city' => 'Bhairahawa / Lumbini',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.5056,
                'longitude' => 83.4161,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Biratnagar Airport',
                'type' => 'airport',
                'iata_code' => 'BIR',
                'city' => 'Biratnagar',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 26.4819,
                'longitude' => 87.2642,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Nepalgunj Airport',
                'type' => 'airport',
                'iata_code' => 'KEP',
                'city' => 'Nepalgunj',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 28.1042,
                'longitude' => 81.6669,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Janakpur Airport',
                'type' => 'airport',
                'iata_code' => 'JYR',
                'city' => 'Janakpur',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 26.7083,
                'longitude' => 85.9239,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Dhangadhi Airport',
                'type' => 'airport',
                'iata_code' => 'DHI',
                'city' => 'Dhangadhi',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 28.7547,
                'longitude' => 80.5828,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Bhadrapur Airport (Jhapa)',
                'type' => 'airport',
                'iata_code' => 'BDP',
                'city' => 'Bhadrapur',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 26.5706,
                'longitude' => 88.0797,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Butwal City Central Hub',
                'type' => 'city',
                'iata_code' => 'BTW',
                'city' => 'Butwal',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.7006,
                'longitude' => 83.4484,
                'timezone' => 'Asia/Kathmandu',
            ],
            [
                'name' => 'Patan Durbar Square Hub',
                'type' => 'city',
                'iata_code' => 'PAT',
                'city' => 'Lalitpur',
                'country' => 'Nepal',
                'country_code' => 'NP',
                'latitude' => 27.6738,
                'longitude' => 85.3250,
                'timezone' => 'Asia/Kathmandu',
            ],
        ];

        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Location::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        foreach ($locations as $loc) {
            Location::create(
                array_merge($loc, [
                    'slug' => Str::slug($loc['city'] . '-' . $loc['iata_code']),
                    'is_active' => true,
                ])
            );
        }
    }
}
