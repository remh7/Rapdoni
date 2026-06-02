<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // ==================== Relationships ====================
    
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    // ==================== Scopes ====================
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
    
    public function scopeForAdmin($query)
    {
        return $query->ordered();
    }
    
    public function scopeForFrontend($query)
    {
        return $query->active()->ordered();
    }

    // ================ اسکوپ جدید برای صفحات اصلی ================
    
    public function scopeWithActiveSongs($query)
    {
        return $query->withCount(['songs' => function($q) {
            $q->where('is_active', true);
        }])->having('songs_count', '>', 0);
    }

    // ==================== Helper Methods ====================
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function getSongCountAttribute()
    {
        return $this->songs()->active()->count();
    }
    
    public function getFormattedColorAttribute()
    {
        return $this->color ?? '#6366f1';
    }

    // ==================== Static Methods ====================
    
    public static function getAdminList()
    {
        return self::forAdmin()->paginate(15);
    }
    
    public static function getForFrontend()
    {
        return self::forFrontend()->get();
    }
    
    public static function getWithSongsCount()
    {
        return self::forFrontend()
            ->withCount('songs')
            ->get();
    }
    
    public static function getCategoriesWithActiveSongs()
    {
        return self::withActiveSongs()->get();
    }
    
    public static function createCategory(array $data)
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        
        return self::create($data);
    }
}