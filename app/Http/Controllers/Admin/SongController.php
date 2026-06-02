<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Category;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::getAdminList();
        return view('admin.songs.index', compact('songs'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $artists = Artist::where('is_active', true)->orderBy('name')->get();
        return view('admin.songs.create', compact('categories', 'artists'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'artist_name' => 'required|string|max:255',
                'artist_id' => 'nullable|exists:artists,id', 
                'category_id' => 'nullable|exists:categories,id',
                'song_file' => 'required|file|mimes:mp3,wav,ogg|max:10240',
                'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
                'duration' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            if (!$request->hasFile('song_file')) {
                return back()->with('error', 'فایل آهنگ ارسال نشده است');
            }

            $songFile = $request->file('song_file');
            
            if (!$songFile->isValid()) {
                return back()->with('error', 'فایل معتبر نیست');
            }

            $songPath = $songFile->store('songs', 'public');
            
            if (!$songPath) {
                return back()->with('error', 'فایل آپلود نشد');
            }
            
            $coverPath = null;
            if ($request->hasFile('cover_image')) {
                $coverPath = $request->file('cover_image')->store('covers', 'public');
            }
            
            $durationInSeconds = 0;
            if ($request->duration) {
                $parts = explode(':', $request->duration);
                if (count($parts) == 2) {
                    $durationInSeconds = (int)$parts[0] * 60 + (int)$parts[1];
                }
            }

           
            $artistName = $request->artist_name;
            if ($request->artist_id) {
                $artist = Artist::find($request->artist_id);
                if ($artist) {
                    $artistName = $artist->name;
                }
            }

            $song = Song::create([
                'title' => $request->title,
                'artist_name' => $artistName,
                'artist_id' => $request->artist_id,  
                'category_id' => $request->category_id,
                'file_path' => $songPath,
                'cover_image' => $coverPath,
                'duration' => $durationInSeconds,
                'plays_count' => 0,
                'is_active' => $request->has('is_active'),
                'uploaded_by' => auth()->id()
            ]);

            if ($song) {
                return redirect()->route('admin.songs.index')
                    ->with('success', 'آهنگ با موفقیت اضافه شد');
            }
            
            return back()->with('error', 'خطا در ذخیره اطلاعات');
            
        } catch (\Exception $e) {
            return back()->with('error', 'خطا: ' . $e->getMessage());
        }
    }

    public function edit(Song $song)
    {
        $categories = Category::all();
        $artists = Artist::where('is_active', true)->orderBy('name')->get();  
        return view('admin.songs.edit', compact('song', 'categories', 'artists')); 
    }
    
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_name' => 'required|string|max:255',
            'artist_id' => 'nullable|exists:artists,id',  
            'category_id' => 'nullable|exists:categories,id',
            'song_file' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'duration' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        
        if ($request->hasFile('song_file')) {
            if ($song->file_path) {
                Storage::disk('public')->delete($song->file_path);
            }
            $songPath = $request->file('song_file')->store('songs', 'public');
            $song->file_path = $songPath;
        }

       
        if ($request->hasFile('cover_image')) {
            if ($song->cover_image) {
                Storage::disk('public')->delete($song->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $song->cover_image = $coverPath;
        }
        
       
        $durationInSeconds = 0;
        if ($request->duration) {
            $parts = explode(':', $request->duration);
            if (count($parts) == 2) {
                $durationInSeconds = (int)$parts[0] * 60 + (int)$parts[1];
            }
        }

    
        $artistName = $request->artist_name;
        if ($request->artist_id) {
            $artist = Artist::find($request->artist_id);
            if ($artist) {
                $artistName = $artist->name;
            }
        }

        $song->update([
            'title' => $request->title,
            'artist_name' => $artistName,
            'artist_id' => $request->artist_id,  
            'category_id' => $request->category_id,
            'duration' => $durationInSeconds,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.songs.index')
            ->with('success', 'آهنگ با موفقیت ویرایش شد');
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
        
        return view('song.show', compact('song', 'relatedSongs'));
    }

    public function destroy(Song $song)
    {
        if ($song->file_path) {
            Storage::disk('public')->delete($song->file_path);
        }
        if ($song->cover_image) {
            Storage::disk('public')->delete($song->cover_image);
        }
        
        $song->delete();

        return redirect()->route('admin.songs.index')
            ->with('success', 'آهنگ با موفقیت حذف شد');
    }
}