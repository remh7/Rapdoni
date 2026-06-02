<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        
        $latestSongs = Song::latestSongs(12)->get();
        $popularSongs = Song::Popular(8)->get();
        $categories = Category::WithActiveSongs()->get();
        $randomSongs = Song::RandomSongs(6)->get();
        
        return view('home', compact('latestSongs', 'popularSongs', 'categories', 'randomSongs'));
    }
}