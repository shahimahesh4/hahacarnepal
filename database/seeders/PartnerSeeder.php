<?php

namespace Database\Seeders;

use App\Models\DriverProfile;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Bikash Gurung',
                'email' => 'bikash@hahacar.com',
                'phone' => '+977 9841234567',
                'city' => 'Kathmandu',
                'partner_type' => 'individual_driver',
                'status' => 'verified',
                'license_no' => '01-06-00459812',
                'rating' => 4.95,
                'total_bookings' => 42,
                'verified_at' => now()->subMonths(3),
                'vehicle' => [
                    'category' => 'suv_4wd',
                    'make' => 'Mahindra',
                    'model' => 'Scorpio 4WD S11',
                    'year' => 2024,
                    'plate_number' => 'Ba 2 Cha 4521',
                    'seating_capacity' => 7,
                    'luggage_capacity' => 4,
                    'transmission' => 'manual',
                    'fuel_type' => 'diesel',
                    'has_ac' => true,
                    'has_4wd' => true,
                    'daily_rate' => 4500,
                    'provides_driver' => true,
                    'allows_self_drive' => true,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
                ],
            ],
            [
                'name' => 'Suresh Thapa',
                'email' => 'suresh@hahacar.com',
                'phone' => '+977 9856012345',
                'city' => 'Pokhara',
                'partner_type' => 'vehicle_owner',
                'status' => 'verified',
                'license_no' => '04-06-00891234',
                'rating' => 4.90,
                'total_bookings' => 28,
                'verified_at' => now()->subMonths(2),
                'vehicle' => [
                    'category' => 'suv_4wd',
                    'make' => 'Toyota',
                    'model' => 'Hilux 4x4 Double Cab',
                    'year' => 2023,
                    'plate_number' => 'Ga 1 Cha 8920',
                    'seating_capacity' => 5,
                    'luggage_capacity' => 5,
                    'transmission' => 'manual',
                    'fuel_type' => 'diesel',
                    'has_ac' => true,
                    'has_4wd' => true,
                    'daily_rate' => 6500,
                    'provides_driver' => true,
                    'allows_self_drive' => true,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1559416523-140ddc3d238c?auto=format&fit=crop&w=1200&h=750&q=85',
                ],
            ],
            [
                'name' => 'Sunil Shrestha',
                'email' => 'sunil@hahacar.com',
                'phone' => '+977 9801234568',
                'city' => 'Kathmandu',
                'partner_type' => 'fleet_operator',
                'status' => 'verified',
                'license_no' => '01-05-00124567',
                'rating' => 4.88,
                'total_bookings' => 64,
                'verified_at' => now()->subMonths(5),
                'vehicle' => [
                    'category' => 'tourist_van',
                    'make' => 'Toyota',
                    'model' => 'HiAce Tourist Commuter 14-Seat',
                    'year' => 2023,
                    'plate_number' => 'Ba 1 Ja 9912',
                    'seating_capacity' => 14,
                    'luggage_capacity' => 8,
                    'transmission' => 'manual',
                    'fuel_type' => 'diesel',
                    'has_ac' => true,
                    'has_4wd' => false,
                    'daily_rate' => 7000,
                    'provides_driver' => true,
                    'allows_self_drive' => false,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?auto=format&fit=crop&w=1200&h=750&q=85',
                ],
            ],
            [
                'name' => 'Deepak Chaudhary',
                'email' => 'deepak@hahacar.com',
                'phone' => '+977 9812345679',
                'city' => 'Chitwan',
                'partner_type' => 'vehicle_owner',
                'status' => 'verified',
                'license_no' => '03-04-00678912',
                'rating' => 4.92,
                'total_bookings' => 19,
                'verified_at' => now()->subMonths(1),
                'vehicle' => [
                    'category' => 'compact_suv',
                    'make' => 'Hyundai',
                    'model' => 'Creta SX',
                    'year' => 2024,
                    'plate_number' => 'Na 3 Cha 3311',
                    'seating_capacity' => 5,
                    'luggage_capacity' => 3,
                    'transmission' => 'automatic',
                    'fuel_type' => 'petrol',
                    'has_ac' => true,
                    'has_4wd' => false,
                    'daily_rate' => 3800,
                    'provides_driver' => true,
                    'allows_self_drive' => true,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&h=750&q=85',
                ],
            ],
            [
                'name' => 'Anil Shakya',
                'email' => 'anil@hahacar.com',
                'phone' => '+977 9823456780',
                'city' => 'Kathmandu',
                'partner_type' => 'individual_driver',
                'status' => 'verified',
                'license_no' => '01-08-00994321',
                'rating' => 4.85,
                'total_bookings' => 31,
                'verified_at' => now()->subWeeks(6),
                'vehicle' => [
                    'category' => 'hatchback',
                    'make' => 'Suzuki',
                    'model' => 'Swift VXI',
                    'year' => 2023,
                    'plate_number' => 'Ba 3 Cha 1204',
                    'seating_capacity' => 5,
                    'luggage_capacity' => 2,
                    'transmission' => 'manual',
                    'fuel_type' => 'petrol',
                    'has_ac' => true,
                    'has_4wd' => false,
                    'daily_rate' => 2600,
                    'provides_driver' => true,
                    'allows_self_drive' => true,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1590362891988-f77804702088?auto=format&fit=crop&w=1200&h=750&q=85',
                ],
            ],
            [
                'name' => 'Ramesh Sharma',
                'email' => 'ramesh@hahacar.com',
                'phone' => '+977 9841999888',
                'city' => 'Kathmandu',
                'partner_type' => 'vehicle_owner',
                'status' => 'pending', // Pending verification for Admin demo
                'license_no' => '01-06-00911222',
                'rating' => 5.00,
                'total_bookings' => 0,
                'verified_at' => null,
                'vehicle' => [
                    'category' => 'luxury_suv',
                    'make' => 'Toyota',
                    'model' => 'Land Cruiser Prado TX',
                    'year' => 2023,
                    'plate_number' => 'Ba 1 Cha 7788',
                    'seating_capacity' => 7,
                    'luggage_capacity' => 5,
                    'transmission' => 'automatic',
                    'fuel_type' => 'diesel',
                    'has_ac' => true,
                    'has_4wd' => true,
                    'daily_rate' => 12000,
                    'provides_driver' => true,
                    'allows_self_drive' => false,
                    'vehicle_photo_path' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&h=750&q=85',
                ],
            ],
        ];

        foreach ($partners as $p) {
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'phone' => $p['phone'],
                    'password' => Hash::make('password'),
                    'role' => 'driver',
                    'status' => 'active',
                ]
            );

            $profile = DriverProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'partner_type' => $p['partner_type'],
                    'status' => $p['status'],
                    'service_city' => $p['city'],
                    'service_area' => 'Bagmati & Gandaki Province',
                    'license_number' => $p['license_no'],
                    'license_photo_path' => 'uploads/licenses/sample_license.jpg',
                    'bluebook_photo_path' => 'uploads/bluebooks/sample_bluebook.jpg',
                    'citizenship_photo_path' => 'uploads/citizenships/sample_citizenship.jpg',
                    'rating' => $p['rating'],
                    'total_bookings' => $p['total_bookings'],
                    'verified_at' => $p['verified_at'],
                ]
            );

            Vehicle::updateOrCreate(
                ['plate_number' => $p['vehicle']['plate_number']],
                [
                    'driver_profile_id' => $profile->id,
                    'category' => $p['vehicle']['category'],
                    'make' => $p['vehicle']['make'],
                    'model' => $p['vehicle']['model'],
                    'year' => $p['vehicle']['year'],
                    'seating_capacity' => $p['vehicle']['seating_capacity'],
                    'luggage_capacity' => $p['vehicle']['luggage_capacity'],
                    'transmission' => $p['vehicle']['transmission'],
                    'fuel_type' => $p['vehicle']['fuel_type'],
                    'has_ac' => $p['vehicle']['has_ac'],
                    'has_4wd' => $p['vehicle']['has_4wd'],
                    'daily_rate' => $p['vehicle']['daily_rate'],
                    'provides_driver' => $p['vehicle']['provides_driver'],
                    'allows_self_drive' => $p['vehicle']['allows_self_drive'],
                    'vehicle_photo_path' => $p['vehicle']['vehicle_photo_path'],
                    'is_active' => true,
                ]
            );
        }
    }
}
