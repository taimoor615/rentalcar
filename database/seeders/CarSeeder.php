<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run()
    {
        $owners = User::where('role', 'owner')->get();

        $cars = [
            [
                'title' => '2023 Tesla Model 3 - Luxury Electric Sedan',
                'make' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2023,
                'daily_rate' => 120.00,
                'location' => 'San Francisco, CA',
                'specs' => [
                    'transmission' => 'Automatic',
                    'fuel_type' => 'Electric',
                    'seats' => 5,
                    'doors' => 4,
                    'features' => ['GPS Navigation', 'Bluetooth', 'Backup Camera', 'Autopilot', 'Supercharging']
                ]
            ],
            [
                'title' => '2022 BMW X5 - Premium SUV',
                'make' => 'BMW',
                'model' => 'X5',
                'year' => 2022,
                'daily_rate' => 95.00,
                'location' => 'Los Angeles, CA',
                'specs' => [
                    'transmission' => 'Automatic',
                    'fuel_type' => 'Gasoline',
                    'seats' => 7,
                    'doors' => 4,
                    'features' => ['GPS Navigation', 'Bluetooth', 'Leather Seats', 'Sunroof', 'All-Wheel Drive']
                ]
            ],
            [
                'title' => '2021 Honda Civic - Reliable Compact Car',
                'make' => 'Honda',
                'model' => 'Civic',
                'year' => 2021,
                'daily_rate' => 45.00,
                'location' => 'New York, NY',
                'specs' => [
                    'transmission' => 'CVT',
                    'fuel_type' => 'Gasoline',
                    'seats' => 5,
                    'doors' => 4,
                    'features' => ['GPS Navigation', 'Bluetooth', 'Backup Camera', 'Honda Sensing']
                ]
            ],
            [
                'title' => '2023 Ford Mustang Convertible - Sports Car',
                'make' => 'Ford',
                'model' => 'Mustang',
                'year' => 2023,
                'daily_rate' => 85.00,
                'location' => 'Miami, FL',
                'specs' => [
                    'transmission' => 'Manual',
                    'fuel_type' => 'Gasoline',
                    'seats' => 4,
                    'doors' => 2,
                    'features' => ['Convertible Top', 'Premium Sound System', 'Performance Package', 'GPS Navigation']
                ]
            ],
            [
                'title' => '2022 Jeep Wrangler - Off-Road Adventure',
                'make' => 'Jeep',
                'model' => 'Wrangler',
                'year' => 2022,
                'daily_rate' => 75.00,
                'location' => 'Denver, CO',
                'specs' => [
                    'transmission' => 'Manual',
                    'fuel_type' => 'Gasoline',
                    'seats' => 5,
                    'doors' => 4,
                    'features' => ['4WD', 'Removable Doors', 'Roll Bars', 'All-Terrain Tires', 'Rock Rails']
                ]
            ],
            [
                'title' => '2023 Audi Q7 - Luxury Family SUV',
                'make' => 'Audi',
                'model' => 'Q7',
                'year' => 2023,
                'daily_rate' => 110.00,
                'location' => 'Seattle, WA',
                'specs' => [
                    'transmission' => 'Automatic',
                    'fuel_type' => 'Gasoline',
                    'seats' => 7,
                    'doors' => 4,
                    'features' => ['Quattro AWD', 'Virtual Cockpit', 'Bang & Olufsen Sound', 'Panoramic Sunroof']
                ]
            ],
            [
                'title' => '2021 Toyota Camry - Midsize Sedan',
                'make' => 'Toyota',
                'model' => 'Camry',
                'year' => 2021,
                'daily_rate' => 55.00,
                'location' => 'Phoenix, AZ',
                'specs' => [
                    'transmission' => 'CVT',
                    'fuel_type' => 'Hybrid',
                    'seats' => 5,
                    'doors' => 4,
                    'features' => ['Toyota Safety Sense', 'Wireless Charging', 'Apple CarPlay', 'Android Auto']
                ]
            ],
            [
                'title' => '2023 Mercedes-Benz C-Class - Luxury Sedan',
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'year' => 2023,
                'daily_rate' => 100.00,
                'location' => 'Chicago, IL',
                'specs' => [
                    'transmission' => 'Automatic',
                    'fuel_type' => 'Gasoline',
                    'seats' => 5,
                    'doors' => 4,
                    'features' => ['MBUX Infotainment', 'Burmester Sound', 'Ambient Lighting', 'Driver Assistance Package']
                ]
            ]
        ];

        foreach ($cars as $index => $carData) {
            $owner = $owners->random();
            $carData['owner_id'] = $owner->id;
            Car::create($carData);
        }

        // Create additional random cars
        $carMakes = ['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan', 'BMW', 'Audi', 'Mercedes-Benz', 'Volkswagen', 'Hyundai'];
        $locations = [
            'Los Angeles, CA', 'New York, NY', 'Chicago, IL', 'Houston, TX', 'Phoenix, AZ',
            'Philadelphia, PA', 'San Antonio, TX', 'San Diego, CA', 'Dallas, TX', 'San Jose, CA',
            'Austin, TX', 'Jacksonville, FL', 'Fort Worth, TX', 'Columbus, OH', 'Charlotte, NC'
        ];

        for ($i = 0; $i < 25; $i++) {
            $make = $carMakes[array_rand($carMakes)];
            $models = $this->getModelsForMake($make);
            $model = $models[array_rand($models)];
            $year = rand(2018, 2023);

            Car::create([
                'owner_id' => $owners->random()->id,
                'title' => $year . ' ' . $make . ' ' . $model . ' - ' . $this->getRandomTitle(),
                'make' => $make,
                'model' => $model,
                'year' => $year,
                'daily_rate' => rand(35, 150) + rand(0, 99) / 100,
                'location' => $locations[array_rand($locations)],
                'specs' => [
                    'transmission' => rand(0, 1) ? 'Automatic' : 'Manual',
                    'fuel_type' => ['Gasoline', 'Hybrid', 'Electric'][rand(0, 2)],
                    'seats' => rand(2, 8),
                    'doors' => rand(2, 4),
                    'features' => $this->getRandomFeatures()
                ]
            ]);
        }
    }

    private function getModelsForMake($make)
    {
        $models = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Prius'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Insight'],
            'Ford' => ['Mustang', 'F-150', 'Explorer', 'Escape', 'Focus'],
            'Chevrolet' => ['Malibu', 'Cruze', 'Equinox', 'Tahoe', 'Silverado'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Pathfinder', 'Leaf'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'i3'],
            'Audi' => ['A3', 'A4', 'Q5', 'Q7', 'e-tron'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE', 'EQS'],
            'Volkswagen' => ['Jetta', 'Passat', 'Tiguan', 'Atlas', 'ID.4'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Ioniq']
        ];

        return $models[$make] ?? ['Model'];
    }

    private function getRandomTitle()
    {
        $titles = [
            'Perfect for City Driving',
            'Great for Road Trips',
            'Luxury Experience',
            'Family Friendly',
            'Sports Car Thrill',
            'Fuel Efficient Choice',
            'Premium Comfort',
            'Adventure Ready',
            'Daily Driver',
            'Weekend Special'
        ];

        return $titles[array_rand($titles)];
    }

    private function getRandomFeatures()
    {
        $allFeatures = [
            'GPS Navigation', 'Bluetooth', 'Backup Camera', 'Heated Seats',
            'Air Conditioning', 'Cruise Control', 'USB Ports', 'Wireless Charging',
            'Apple CarPlay', 'Android Auto', 'Sunroof', 'Leather Seats',
            'Premium Sound System', 'Keyless Entry', 'Push Button Start',
            'Lane Departure Warning', 'Blind Spot Monitoring', 'Parking Sensors'
        ];

        $numberOfFeatures = rand(3, 8);
        return array_slice($allFeatures, 0, $numberOfFeatures);
    }
}
