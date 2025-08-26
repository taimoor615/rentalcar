<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create test owners
        User::create([
            'name' => 'John Owner',
            'email' => 'john@owner.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Sarah Car Owner',
            'email' => 'sarah@owner.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Mike Fleet Owner',
            'email' => 'mike@owner.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        // Create test renters
        User::create([
            'name' => 'Alice Renter',
            'email' => 'alice@renter.com',
            'password' => Hash::make('password'),
            'role' => 'renter',
        ]);

        User::create([
            'name' => 'Bob Customer',
            'email' => 'bob@renter.com',
            'password' => Hash::make('password'),
            'role' => 'renter',
        ]);

        User::create([
            'name' => 'Emma Driver',
            'email' => 'emma@renter.com',
            'password' => Hash::make('password'),
            'role' => 'renter',
        ]);

        User::create([
            'name' => 'David Traveler',
            'email' => 'david@renter.com',
            'password' => Hash::make('password'),
            'role' => 'renter',
        ]);

        // Create additional users for more realistic data
        User::factory(15)->create(['role' => 'owner']);
        User::factory(25)->create(['role' => 'renter']);
    }
}
