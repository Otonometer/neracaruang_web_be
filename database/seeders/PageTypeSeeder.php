<?php

namespace Database\Seeders;

use App\Models\PageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageTypeSeeder extends Seeder
{
    private array $types = [
        'kabar',
        'jurnal',
        'infografis',
        'video',
        'album foto',
        'diskusi'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->types as $type ) {
            PageType::create([
                'title' => $type,
                'slug' => STR::slug($type)
            ]);
        }
    }
}
