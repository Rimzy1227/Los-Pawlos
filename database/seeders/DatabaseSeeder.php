<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LegacyImportSeeder::class,
            // CategorySeeder and ProductSeeder are redundant now since LegacyImportSeeder handles them
            // but we can keep them if we want to ensure basic data even if legacy file is missing
            // However, LegacyImportSeeder truncates, so it should be called last or instead of them.
        ]);
    }
}
