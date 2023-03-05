<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);

        $open_tickets = $user->tickets()->where('status', 'open')->count();
        $all_tickets = Ticket::count();
        $user_count = User::count()
        
        return view('dashboard', compact('user', 'open_tickets', 'all_tickets', 'user_count'));
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);

        return view('profile', compact('user'));
    }
}
