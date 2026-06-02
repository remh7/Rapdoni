<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Category;
use Illuminate\Http\Request;

class SongController extends Controller
{
   
   public function index(Request $request)
{
    $query = Song::with('category')->active()->latest();
    
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('artist_name', 'like', "%{$search}%");
        });
    }
    
    
    if ($request->has('category') && $request->category) {
        $query->where('category_id', $request->category);
    }
    
    $songs = $query->paginate(20);
   
    $categories = Category::withActiveSongs()->get();
    
    return view('front.songs.index', compact('songs', 'categories'));
}
    
   
    public function show($id)
    {
        $song = Song::with('category')->findOrFail($id);
        

        $relatedSongs = Song::where('category_id', $song->category_id)
            ->where('id', '!=', $song->id)
            ->active()
            ->latest()
            ->take(5)
            ->get();
        
     
        $song->increment('plays_count');
        
        return view('front.songs.show', compact('song', 'relatedSongs'));
    }
    
 
    public function download($id)
    {
        $song = Song::findOrFail($id);
        $filePath = storage_path('app/public/' . $song->file_path);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, $song->title . ' - ' . $song->artist_name . '.mp3');
    }
}