<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('categories')->insert([
            ['name' => 'Category 1',
                'code'=>'CATEGORY-1',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'Category 2',
                'code'=>'CATEGORY-2',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'Category 3',
                'code'=>'CATEGORY-3',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'Lain-lain',
                'code'=>'LAIN-LAIN',
                'created_at' => now(),
                'updated_at' => now()],
        ]);
    }
}
