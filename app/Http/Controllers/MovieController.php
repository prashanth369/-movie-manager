<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\File;
use App\Models\Category;
use App\Models\MovieCategory;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Movie::with('movie_files', 'movie_categories')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $movie = new Movie;
        $file = new File;
        $category = new Category;

        //Get data for the movie record
        $movie->name = $request->name;
        $movie->imdb_score = $request->imdb_score;
        $movie->release_date = $request->release_date;
        $movie->description = $request->description;
        $movie->save();

        //Get the file details
        $file->movie_id = $movie->id;
        $file->title = $request->image_title;
        $file->content = $request->image;
        $file->save();

        //Get all the categories added to the movie
        $movie_category_ids = $category->whereIn('slug', $request->category)->pluck('id');
        
        //Save all the movie categories data into the table
        foreach($movie_category_ids as $category_id) {
            $movie_category = new MovieCategory;

            $movie_category->movie_id = $movie->id;
            $movie_category->category_id = $category_id;
            $movie_category->save();

        }

        return $movie;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::find($id);
        $movie_files = File::all()->where('');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}