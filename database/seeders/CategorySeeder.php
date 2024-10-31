<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'tokoh',
            'topik',
            'otonomi daerah'
        ];

        foreach ($categories as $category) {
            Category::create([
                'title' => Str::ucfirst($category),
                'slug' => Str::slug($category)
            ]);
        }
    }
}
