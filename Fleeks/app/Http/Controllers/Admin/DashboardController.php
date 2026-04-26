<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'pending_reservations' => Reservation::query()->where('status', 'pending')->count(),
            'rooms' => Room::query()->count(),
        ]);
    }
}

