<?php

namespace Database\Factories;

use App\Models\Content;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{

    protected $model = Content::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => Str::slug(fake()->sentence(4)),
            'summary' => fake()->sentence(5),
            'content' => fake()->text(),
            'page_type_id' => random_int(1,5),
            'image' => '',
            'location_id' => random_int(1,50),
            'created_by' => 1,
            'publish_date' => Carbon::now(),
            'status' => 'publish'
        ];
    }
}
