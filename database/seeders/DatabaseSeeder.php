<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $categories_data = array(
            [
                'id' => 1,
                'name' => 'Action',
                'slug' => 'action'
            ],
            [
                'id' => 2,
                'name' => 'Animation',
                'slug' => 'animation'
            ],
            [
                'id' => 3,
                'name' => 'Comedy',
                'slug' => 'comedy'
            ],
            [
                'id' => 4,
                'name' => 'Crime',
                'slug' => 'crime'
            ],
            [
                'id' => 5,
                'name' => 'Drama',
                'slug' => 'drama'
            ],
            [
                'id' => 6,
                'name' => 'Experimental',
                'slug' => 'experimental'
            ],
            [
                'id' => 7,
                'name' => 'Fantasy',
                'slug' => 'fantasy'
            ],
            [
                'id' => 8,
                'name' => 'Historical',
                'slug' => 'historical'
            ],
            [
                'id' => 9,
                'name' => 'Horror',
                'slug' => 'horror'
            ],
            [
                'id' => 10,
                'name' => 'Romance',
                'slug' => 'romance'
            ],
            [
                'id' => 11,
                'name' => 'Science Fiction',
                'slug' => 'science_fiction'
            ],
            [
                'id' => 12,
                'name' => 'Thriller',
                'slug' => 'thriller'
            ],
            [
                'id' => 13,
                'name' => 'Western',
                'slug' => 'western'
            ],
            [
                'id' => 14,
                'name' => 'Other',
                'slug' => 'other'
            ]
        );

        foreach($categories_data as $data) {
            $category = new Category($data);
            $category->save();
        }
    }
}