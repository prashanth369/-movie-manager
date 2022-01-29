<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCategory extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'category_id'];

    public function movies() {
        return $this->belongsTo('App\Models\Movie', 'id', 'movie_id');
    }

    public function categories() {
        return $this->belongsTo('App\Models\Category', 'id', 'category_id');
    }
}