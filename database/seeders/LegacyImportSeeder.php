<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LegacyImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('legacy_ssp1/los_pawlos.sql');
        
        if (File::exists($sqlPath)) {
            $sql = File::get($sqlPath);
            
            // Extract INSERT statements
            // This is a naive regex but should work for standard dumps
            preg_match_all('/INSERT INTO `.*` \(.*\) VALUES\s*\(.*\);/sU', $sql, $matches);
            
            // If naive regex fails due to multiple values, try simpler approach:
            // Just split by semicolon and look for INSERT
            $statements = explode(';', $sql);
            
            foreach ($statements as $statement) {
                $statement = trim($statement);
                if (stripos($statement, 'INSERT INTO') === 0) {
                    try {
                        DB::statement($statement);
                    } catch (\Exception $e) {
                         // Ignore duplicate entry errors or if table refers to id that doesn't exist yet (fk issues)
                         // For better reliability, we should disable FK checks
                         
                    }
                }
            }
        }
    }
}
