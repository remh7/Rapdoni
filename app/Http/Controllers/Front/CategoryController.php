<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Song;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['songs' => function($query) {
            $query->where('is_active', true);
        }])->orderBy('name')->get();
        
        return view('front.categories.index', compact('categories'));
    }
    
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $songs = Song::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(20);
        
        $otherCategories = Category::where('id', '!=', $category->id)
            ->withCount(['songs' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name')
            ->take(10)
            ->get();
        
        return view('front.categories.show', compact('category', 'songs', 'otherCategories'));
    }
}