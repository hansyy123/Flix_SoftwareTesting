<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class PendingReservationsController extends Controller
{
    public function index()
    {
        $reservations = Reservation::query()
            ->with(['user', 'room'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.reservations.pending', [
            'reservations' => $reservations,
        ]);
    }

    public function approve(Request $request, Reservation $reservation)
    {
        return DB::transaction(function () use ($request, $reservation) {
            $reservation->refresh();

            if ($reservation->status !== 'pending') {
                return back()->with('status', 'Reservation already reviewed.');
            }

            $conflict = Reservation::query()
                ->where('room_id', $reservation->room_id)
                ->approved()
                ->overlapping($reservation->starts_at, $reservation->ends_at)
                ->exists();

            if ($conflict) {
                $reservation->forceFill([
                    'status' => 'rejected',
                    'admin_note' => 'Auto-rejected due to schedule conflict with an approved reservation.',
                    'reviewed_by' => $request->user()->id,
                    'reviewed_at' => now(),
                ])->save();

                return back()->with('status', 'Reservation rejected due to schedule conflict.');
            }

            $reservation->forceFill([
                'status' => 'approved',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ])->save();

            return back()->with('status', 'Reservation approved.');
        });
    }

    public function reject(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $reservation->forceFill([
            'status' => 'rejected',
            'admin_note' => $data['admin_note'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ])->save();

        return back()->with('status', 'Reservation rejected.');
    }

    public function proof(Reservation $reservation)
    {
        abort_unless(
            $reservation->payment_proof_path && Storage::disk('public')->exists($reservation->payment_proof_path),
            404
        );

        return response()->file(Storage::disk('public')->path($reservation->payment_proof_path));
    }
}

