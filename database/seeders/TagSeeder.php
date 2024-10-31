<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsCategory = [
            1 => [
                'pemerintahan',
                'wakil rakyat',
                'penegak hukum',
                'peradilan',
            ],
            2 => [
                'pendapatan daerah',
                'dana bagi hasil',
                'pajak',
                'retribusi',
                'transer pusat'
            ],
            3 => [
                'pendidikan',
                'kesehatan',
                'informasi'
            ]
        ];

        foreach ($tagsCategory as $category => $tags) {
            foreach ($tags as $tag ) {
                Tag::create([
                    'title' => Str::ucfirst($tag),
                    'slug' => Str::slug($tag),
                    'category_id' => $category
                ]);
            }
        }
    }
}
