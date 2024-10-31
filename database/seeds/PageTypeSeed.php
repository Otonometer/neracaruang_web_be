<?php

namespace Database\Seeders;

use App\Models\PageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = [
            'kabar',
            'jurnal',
            'infografis',
            'video',
            'album foto',
            'diskusi',
        ];
        foreach ($type as $item) {
            PageType::create([
                'title' => $item,
                'slug' => Str::slug($item)
            ]);
        }
    }
}
