<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Song;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSongs = Song::count();
        $totalUsers = User::count();
        $totalPlays = Song::sum('plays_count');
        $latestSongs = Song::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalSongs', 'totalUsers', 'totalPlays', 'latestSongs'));
    }
}