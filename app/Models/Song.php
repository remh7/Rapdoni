<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Song extends Model
{
    protected $fillable = [
        'title',
        'artist_name',
        'category_id',
        'file_path',
        'cover_image',
        'duration',
        'plays_count',
        'is_active',
        'uploaded_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration' => 'integer',
        'plays_count' => 'integer'
    ];

    // ==================== Relationships ====================
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ==================== Scopes ====================
    
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeLatestSongs(Builder $query, int $limit = 10): Builder
    {
        return $query->active()->latest()->limit($limit);
    }

    public function scopePopular(Builder $query, int $limit = 8): Builder
    {
        return $query->active()->orderBy('plays_count', 'desc')->limit($limit);
    }

    public function scopeRandomSongs(Builder $query, int $limit = 6): Builder
    {
        return $query->active()->inRandomOrder()->limit($limit);
    }

    public function scopeByCategory(Builder $query, $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if ($keyword) {
            return $query->where('title', 'like', "%{$keyword}%")
                         ->orWhere('artist_name', 'like', "%{$keyword}%");
        }
        return $query;
    }

    // ==================== Accessors ====================
    
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '00:00';
        }
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf("%d:%02d", $minutes, $seconds);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if ($this->cover_image) {
            return Storage::url($this->cover_image);
        }
        return null;
    }

    public function getSongUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    // ==================== Helper Methods ====================
    
    public function incrementPlays(): void
    {
        $this->increment('plays_count');
    }

    public function toggleStatus(): void
    {
        $this->update(['is_active' => !$this->is_active]);
    }

    // ==================== Static Methods ====================
    
    public static function getAdminList()
    {
        return self::with(['category', 'uploader'])
            ->latest()
            ->paginate(15);
    }

    public static function getForHomePage()
    {
        return [
            'latest' => self::latestSongs(12)->get(),
            'popular' => self::popular(8)->get(),
            'random' => self::randomSongs(6)->get(),
        ];
    }

    public static function getRelatedSongs($categoryId, $excludeId, $limit = 5)
    {
        return self::active()
            ->byCategory($categoryId)
            ->where('id', '!=', $excludeId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}