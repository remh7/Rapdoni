<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
class Artist extends Model
{
        protected $fillable = [
        'name',
        'slug',
        'avatar',
        'bio',
        'birth_date',
        'genre',
        'is_active'
    ];

        protected $casts = [
        'is_active' => 'boolean',
        'birth_date' => 'date'
    ];


    public function songs(){

        return $this->hasMany(Song::class);

    }

        public function getRouteKeyName()
    {
        return 'slug';
    }

    
protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($artist) {
            if (empty($artist->slug)) {
                $artist->slug = static::generateUniqueSlug($artist->name);
            }
        });
    }

protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    public function scopeActive(Builder $query): Builder
{
    return $query->where('is_active', true);
}
   public static function getPaginatedArtists($limit = 10)
{
    return self::query()->active()->orderBy('name')->paginate($limit);
}

public static function getArtist($slug)
{
    return self::query()->active()->where('id',$slug);
}
}
