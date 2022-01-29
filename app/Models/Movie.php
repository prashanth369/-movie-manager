<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'imdb_score', 'release_date', 'description'];


    public function movie_files() {
        return $this->hasOne('App\Models\File', 'movie_id', 'id');
    }
    
    public function movie_categories() {
        return $this->belongsToMany('App\Models\Category', 'movie_categories');

    }

}