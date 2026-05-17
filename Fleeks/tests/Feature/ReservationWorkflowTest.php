<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_users_are_redirected_to_login_for_protected_pages(): void
    {
        $room = Room::factory()->create();

        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('rooms.show', $room))->assertRedirect(route('login'));
        $this->get(route('reservations.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_dashboard_rooms_and_reservations_pages(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['is_active' => true]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('rooms.show', $room))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('reservations.index'))
            ->assertOk();
    }

    public function test_user_can_cancel_their_reservation(): void
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        $this->actingAs($user)
            ->delete(route('reservations.destroy', $reservation))
            ->assertRedirect(route('reservations.index'))
            ->assertSessionHas('status', 'Your reservation has been cancelled. Admins have been notified.');

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_admin_dashboard_shows_cancelled_reservations_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $room = Room::factory()->create();
        $reservation = Reservation::factory()->create([
            'status' => 'cancelled',
            'room_id' => $room->id,
            'user_id' => User::factory(),
            'movie_title' => 'Test Movie',
            'admin_note' => 'User cancelled this reservation on '.now()->format('Y-m-d H:i'),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('cancelled_reservations', 1)
            ->assertSee('Recent cancellations');
    }

    public function test_admin_dashboard_shows_pending_reservations_and_room_counts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $rooms = Room::factory()->count(3)->create();

        Reservation::factory()->create([
            'status' => 'pending',
            'room_id' => $rooms[0]->id,
            'user_id' => User::factory(),
            'movie_title' => 'Test Movie',
        ]);
        Reservation::factory()->create([
            'status' => 'pending',
            'room_id' => $rooms[1]->id,
            'user_id' => User::factory(),
            'movie_title' => 'Test Movie',
        ]);
        Reservation::factory()->create([
            'status' => 'approved',
            'room_id' => $rooms[2]->id,
            'user_id' => User::factory(),
            'movie_title' => 'Test Movie',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('pending_reservations', 2)
            ->assertViewHas('rooms', 3);
    }

    public function test_payment_proof_is_required_for_gcash_reservations(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['is_active' => true]);
        $movieTitle = config('app.movies')[0] ?? 'Test Movie';

        $this->actingAs($user)
            ->post(route('rooms.reservations.store', $room), [
                'movie_title' => $movieTitle,
                'starts_at' => now()->addDays(3)->setTime(10, 0)->format('Y-m-d\TH:i'),
                'ends_at' => now()->addDays(3)->setTime(12, 0)->format('Y-m-d\TH:i'),
                'payment_method' => 'gcash',
            ])
            ->assertSessionHasErrors(['payment_proof']);
    }

    public function test_payment_proof_is_optional_for_cash_reservations(): void
    {
        $user = User::factory()->create();
        $room = Room::factory()->create(['is_active' => true]);
        $movieTitle = config('app.movies')[0] ?? 'Test Movie';

        $this->actingAs($user)
            ->post(route('rooms.reservations.store', $room), [
                'movie_title' => $movieTitle,
                'starts_at' => now()->addDays(3)->setTime(10, 0)->format('Y-m-d\TH:i'),
                'ends_at' => now()->addDays(3)->setTime(12, 0)->format('Y-m-d\TH:i'),
                'payment_method' => 'cash',
            ])
            ->assertRedirect(route('reservations.index'));

        $this->assertDatabaseHas('reservations', [
            'room_id' => $room->id,
            'payment_method' => 'cash',
            'status' => 'pending',
        ]);
    }
}
