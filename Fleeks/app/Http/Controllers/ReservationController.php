<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::query()
            ->with(['room'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(15);

        return view('reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    public function store(StoreReservationRequest $request, Room $room)
    {
        abort_unless($room->is_active, 404);

        $startsAt = $request->date('starts_at');
        $endsAt = $request->date('ends_at');

        return DB::transaction(function () use ($request, $room, $startsAt, $endsAt) {
            $conflict = Reservation::query()
                ->where('room_id', $room->id)
                ->approved()
                ->overlapping($startsAt, $endsAt)
                ->exists();

            if ($conflict) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'starts_at' => 'This room is already occupied for the selected schedule.',
                    ]);
            }

            $proofPath = null;
            if ($request->hasFile('payment_proof')) {
                $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            $movieTitle = $request->input('movie_title') === 'other'
                ? $request->string('manual_movie_title')->toString()
                : $request->string('movie_title')->toString();

            Reservation::create([
                'user_id' => $request->user()->id,
                'room_id' => $room->id,
                'movie_title' => $movieTitle,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'payment_method' => $request->string('payment_method')->toString(),
                'payment_proof_path' => $proofPath,
                'status' => 'pending',
            ]);

            return redirect()
                ->route('reservations.index')
                ->with('status', 'Reservation request submitted. Please wait for admin approval.');
        });
    }
}

