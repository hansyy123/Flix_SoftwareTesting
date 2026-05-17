<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $startsAt = now()->addDays(2)->setTime(10, 0);

        return [
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'movie_title' => 'Test Movie',
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->addHours(2),
            'payment_method' => 'cash',
            'payment_proof_path' => null,
            'status' => 'pending',
            'admin_note' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];
    }
}

