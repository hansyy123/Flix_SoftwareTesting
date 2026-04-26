<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'account_status' => 'approved',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Sample User',
                'password' => Hash::make('user12345'),
                'role' => 'user',
                'account_status' => 'approved',
            ]
        );

        $rooms = [
            [
                'name' => 'Deluxe Movie Room',
                'description' => 'Cozy private room with a large screen and premium sound — great for small groups.',
                'capacity' => 6,
                'price_per_hour' => 500,
                'image_path' => '/images/rooms/room-01.png',
                'is_active' => true,
            ],
            [
                'name' => 'VIP Cinema Suite',
                'description' => 'Sofas + ambient lighting + enhanced audio for a premium watch experience.',
                'capacity' => 10,
                'price_per_hour' => 900,
                'image_path' => '/images/rooms/room-02.png',
                'is_active' => true,
            ],
            [
                'name' => 'Group Screening Hall',
                'description' => 'Bigger capacity room built for barkada movie nights.',
                'capacity' => 20,
                'price_per_hour' => 1500,
                'image_path' => '/images/rooms/room-03.png',
                'is_active' => true,
            ],
            [
                'name' => 'Couple’s Mini Theater',
                'description' => 'Small, intimate room for two — perfect for dates and chill nights.',
                'capacity' => 2,
                'price_per_hour' => 350,
                'image_path' => '/images/rooms/room-04.png',
                'is_active' => true,
            ],
            [
                'name' => 'Family Movie Room',
                'description' => 'Comfortable seating and kid-friendly setup for family screenings.',
                'capacity' => 8,
                'price_per_hour' => 650,
                'image_path' => '/images/rooms/room-05.png',
                'is_active' => true,
            ],
            [
                'name' => 'Budget Room',
                'description' => 'Simple, clean, and affordable — still a solid screen + sound.',
                'capacity' => 4,
                'price_per_hour' => 300,
                'image_path' => '/images/rooms/room-06.png',
                'is_active' => true,
            ],
            [
                'name' => 'Dolby Dark Room',
                'description' => 'Dark, immersive vibe with punchy bass and crisp dialogue.',
                'capacity' => 6,
                'price_per_hour' => 750,
                'image_path' => '/images/rooms/room-07.png',
                'is_active' => true,
            ],
            [
                'name' => 'Classic Home Theater',
                'description' => 'Warm, homey setup that feels like your own living room cinema.',
                'capacity' => 5,
                'price_per_hour' => 450,
                'image_path' => '/images/rooms/room-08.png',
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::query()->updateOrCreate(
                ['name' => $room['name']],
                $room
            );
        }
    }
}
