<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::getPaginatedArtists();
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function edit($id)
    {
        $artist = Artist::findOrFail($id);
        return view('admin.artists.edit', compact('artist'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:artists',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', 
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('artists', 'public');
        }

        $artist = Artist::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'avatar' => $avatarPath,
            'bio' => $request->bio,
            'birth_date' => $request->birth_date,
            'genre' => $request->genre,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.artists.index')
            ->with('success', 'هنرمند با موفقیت اضافه شد');
    }

    public function update(Request $request, $id)
    {
        $artist = Artist::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:artists,name,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'genre' => 'nullable|string|max:100',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('avatar')) {
            if ($artist->avatar) {
                Storage::disk('public')->delete($artist->avatar); 
            }
            $avatarPath = $request->file('avatar')->store('artists', 'public');
            $artist->avatar = $avatarPath;
        }

        $artist->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'bio' => $request->bio,
            'birth_date' => $request->birth_date,
            'genre' => $request->genre,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.artists.index')
            ->with('success', 'هنرمند با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $artist = Artist::findOrFail($id);

        if ($artist->avatar) {
            Storage::disk('public')->delete($artist->avatar);  
        }

        $artist->delete();

        return redirect()->route('admin.artists.index')
            ->with('success', 'هنرمند با موفقیت حذف شد');
    }
}