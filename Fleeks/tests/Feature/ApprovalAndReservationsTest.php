<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalAndReservationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_overlapping_reservation_is_rejected(): void
    {
        $room = Room::factory()->create();

        Reservation::factory()->create([
            'room_id' => $room->id,
            'status' => 'approved',
            'starts_at' => now()->addDays(3)->setTime(10, 0),
            'ends_at' => now()->addDays(3)->setTime(12, 0),
            'movie_title' => 'Existing Movie',
        ]);

        $user = User::factory()->create([
            'role' => 'user',
            'account_status' => 'approved',
        ]);

        $this->actingAs($user)
            ->post(route('rooms.reservations.store', $room), [
                'movie_title' => 'New Movie',
                'starts_at' => now()->addDays(3)->setTime(11, 0)->format('Y-m-d\TH:i'),
                'ends_at' => now()->addDays(3)->setTime(13, 0)->format('Y-m-d\TH:i'),
                'payment_method' => 'cash',
            ])
            ->assertSessionHasErrors(['starts_at']);
    }

    public function test_non_admin_users_are_forbidden_from_admin_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'account_status' => 'approved',
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}

