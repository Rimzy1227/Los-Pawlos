<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Food'],
            ['id' => 2, 'name' => 'Toys'],
            ['id' => 3, 'name' => 'Grooming'],
            ['id' => 4, 'name' => 'Accessories'],
        ]);
    }
}
