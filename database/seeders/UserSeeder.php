<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Seam Aftab',
            'email' => 'Seam@gmail.com',
            'password' => '11223344',
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'Moderator@gmail.com',
            'password' => '11223344',
            'role_id' => 2,
        ]);
        User::factory(5)->create();
    }
}
