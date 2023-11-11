<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::factory()->create([
            'name' => 'Cellphones',
            'slug' => 'Cellphones',
            'description' => 'Cellphones'
        ]);
        Category::factory()->create([
            'name' => 'Laptops',
            'slug' => 'Laptops',
            'description' => 'Laptops'
        ]);
        Category::factory()->create([
            'name' => 'Accessories',
            'slug' => 'Accessories',
            'description' => 'Accessories'
        ]);
    }
}
