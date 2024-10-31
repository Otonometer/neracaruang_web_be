<?php

namespace Database\Seeders;

use App\Enums\ContentTypes;
use App\Models\Content;
use App\Models\TagsContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
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

        $contents = Content::factory(5)
                    ->create();
        
        $contents->each(fn($content) => TagsContent::create(['content_id' => $content->id,'tag_id' => random_int(1,12)]));

        $contents->each(function($content) {
            if ($content->page_type_id === ContentTypes::ALBUMFOTO->value || $content->page_type_id === ContentTypes::INFOGRAFIS->value) {
                $content->medias()->create([
                    'image' => '',
                    'summary' => fake()->text(10),
                    'media_type' => $content->page_type_id === ContentTypes::ALBUMFOTO->value ? 'image' : 'infografis'
                ]);
            }
        });
    }
}
