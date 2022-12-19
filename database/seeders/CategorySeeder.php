<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'=>'News',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'=>'Sports',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'=>'Musics',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'=>'Books',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name'=>'Cosmetics',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ];
        Category::insert($categories);
    }
}
