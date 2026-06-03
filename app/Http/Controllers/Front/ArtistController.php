<?php

namespace App\Http\Controllers\Front;
use App\Models\Artist;
use App\Models\Song;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    function index(){
     $artists = Artist::active()->withCount([
        'songs'=>fn ($query) => $query->active()
     ])->orderBy('name')->paginate(24);


     return view('front.artists.index',compact('artists'));

    }

   public function show($slug)
{
    $artist = Artist::active()
        ->where('slug', $slug)
        ->firstOrFail();

    $songs = Song::active()
        ->where('artist_id', $artist->id)
        ->with('category')
        ->latest()
        ->paginate(20);

    $popularSongs = Song::active()
        ->where('artist_id', $artist->id)
        ->popular()
        ->take(5)
        ->get();

    $totalPlays = Song::active()
        ->where('artist_id', $artist->id)
        ->sum('plays_count');

    $totalSongs = $artist->songs()
        ->active()
        ->count();

    return view(
        'front.artists.show',
        compact(
            'artist',
            'songs',
            'popularSongs',
            'totalPlays',
            'totalSongs'
        )
    );
}
}
