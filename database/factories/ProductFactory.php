<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
//use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition():array
    {
        $genre = Category::all();
        $randomize = $genre->random();
        $title = $this->faker->realtext(20);

        return [
            'serial' => "202301".fake()->unique()->numerify('######'),
            'title' => $title,
            'slug' => Str::slug($title),
            'price' => rand(100,10000),
            'image' => fake()->imageUrl(),
            'description' => fake()->paragraph,
            'is_active' => true,
            'category' => $randomize->id,
        ];
    }
}
