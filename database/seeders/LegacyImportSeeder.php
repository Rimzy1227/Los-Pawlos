<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class LegacyImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('legacy_ssp1/los_pawlos.sql');
        
        if (File::exists($sqlPath)) {
            $this->command->info("Importing legacy data from {$sqlPath}...");
            $sql = File::get($sqlPath);
            $this->command->info("Loaded SQL file: " . strlen($sql) . " bytes.");
            
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Truncate tables to avoid duplicate key errors
            $tables = ['order_items', 'orders', 'cart_items', 'products', 'categories', 'users'];
            foreach ($tables as $table) {
                if (Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                }
            }

            // Split by semicolon, but handle cases where semicolon is inside strings (naive but usually okay for dumps)
            // A better way is to use a proper SQL parser or just run the whole file via command line
            $statements = explode(';', $sql);
            
            $count = 0;
            foreach ($statements as $statement) {
                $statement = trim($statement);
                
                if (empty($statement)) {
                    continue;
                }

                if (stripos($statement, 'INSERT INTO') !== false) {
                    try {
                        DB::statement($statement);
                        $count++;
                    } catch (\Exception $e) {
                         $this->command->error("Error executing statement: " . substr($statement, 0, 50) . "... Error: " . $e->getMessage());
                    }
                } elseif (str_starts_with($statement, '--') || str_starts_with($statement, '/*')) {
                    continue;
                }
            }

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->command->info("Imported {$count} INSERT statements.");

            // Verify counts
            $this->command->info("Products count: " . DB::table('products')->count());
            $this->command->info("Users count: " . DB::table('users')->count());
        } else {
            $this->command->error("SQL file not found at {$sqlPath}");
        }
    }
}
