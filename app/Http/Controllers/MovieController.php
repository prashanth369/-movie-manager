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
        $data = [];
        $movie_list = Movie::with('movie_files', 'movie_categories')->get();

        foreach($movie_list as $movie) {

            $files = $movie->movie_files->map(function($file) {
                return array(
                    'name' => $file->title,
                    'url' => $file->content
                );
            });

            $data[] = array(
                'id' => $movie->id,
                'title' => $movie->name,
                'description' => $movie->description,
                'imdb_score' => $movie->imdb_score,
                'release_date' => $movie->release_date,
                'files' => $files,
            );
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetch_movie_categories()
    {
        return Category::select(['name', 'slug'])->get();
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
        $file->content = $request->image->getClientOriginalName();
        $filename = $filename = pathinfo($file->content, PATHINFO_FILENAME);
        $file->title = $filename;

        $request->image->move('images', $file->content);
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
     * Display a specific Resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = Movie::with('movie_files', 'movie_categories')->where('id', $id)->first();

        $files = $movie->movie_files->map(function($file) {
            return array(
                'id' => $file->id,
                'name' => $file->title,
                'url' => $file->content
            );
        });

        $movie_categories = $movie->movie_categories->map(function($category) {
            return array(
                'name' => $category->name,
                'slug' => $category->slug
            );
        });

        $data = array(
            'id' => $movie->id,
            'name' => $movie->name,
            'imdb_score' => $movie->imdb_score,
            'release_date' => $movie->release_date,
            'description' => $movie->description,
            'last_updated' => $movie->updated_at,
            'files' => $files,
            'categories' => $movie_categories
        );

        return $data;
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
        $movie = Movie::find($id);

       if(is_null($movie)) {
           return null;
       }

       $updated_movie = $request->movie;
       $update_movie_files_data = $request->movie_files;
       $updated_movie_categories = $request->movie_categories;

       if(!is_null($updated_movie)) {

            if(array_key_exists('name', $updated_movie) && !is_null($updated_movie['name'])) {
                $movie->name = $updated_movie['name'];
            }
            if(array_key_exists('imdb_score', $updated_movie) && !is_null($updated_movie['imdb_score'])) {
                $movie->imdb_score = $updated_movie['imdb_score'];
            }
            if(array_key_exists('release_date', $updated_movie) && !is_null($updated_movie['release_date'])) {
                $movie->release_date = $updated_movie['release_date'];
            }
            if(array_key_exists('description', $updated_movie) && !is_null($updated_movie['description'])) {
                $movie->description = $updated_movie['description'];
            }
           
            $movie->save();

       }
       
        //Update the File changes of the movie
        if(!is_null($update_movie_files_data)) {
            $this->update_file_data($update_movie_files_data, $id);
        }

        return $this->update_movie_categories($updated_movie_categories, $id);

        return $movie;
    }

    public function update_file_data($movie_files, $movie_id) {

        foreach( $movie_files as $file_data) {
            $file = File::find($file_data['id'])->where('movie_id', $movie_id)->first();

            if(!is_null($file)) {

                if(array_key_exists('content', $file_data) && !is_null($file_data['content'])) {
                    $file->content = $file_data['content'];
                }

                if(array_key_exists('title', $file_data) && !is_null($file_data['title'])) {
                    $file->title = $file_data['title'];
                }

                $file->save();
            }
        }
    }

    public function update_movie_categories($movie_categories, $movie_id) {
        $categories = MovieCategory::where('movie_id', $movie_id)->pluck('category_id')->toArray();

        // return $movie_categories;
        $category_ids_to_remove = array_values(array_diff($categories, $movie_categories));
        $category_ids_to_add = array_values(array_diff($movie_categories, $categories));

        foreach($category_ids_to_add as $category_id) {

            $movie_category = new MovieCategory;
            $movie_category->movie_id = $movie_id;
            $movie_category->category_id = $category_id;

            $movie_category->save();
        }

        foreach($category_ids_to_remove as $category_id) {
            $movie_category = MovieCategory::where('movie_id', $movie_id)->where('category_id', $category_id)->first();
            $movie_category->delete();

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $files_to_remove = File::where('movie_id', $id)->delete();
        $movie_categories_to_remove = MovieCategory::where('movie_id', $id)->delete();
        $movie->delete();

        return $movie;;
    }
}