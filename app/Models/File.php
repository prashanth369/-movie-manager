<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'movie_id', 'content'];

    public function movies() {
        return $this->belongsTo('App\Models\Movie', 'id', 'movie_id');
    }

}