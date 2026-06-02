<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'is_read'
    ];
    
    public function scopeUnread($query){
        return $query->where('is_read',false);
    }

    public function scopeToday($query){
        return $query->whereDate('created_at',today());
    }
    public function scopePaginated($query,$perPage){
        return $query->latest()->paginate($perPage);
    }
}
