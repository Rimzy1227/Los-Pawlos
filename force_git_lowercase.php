<?php
// Comprehensive script to force Git to record filename case changes to LOWERCASE
$directories = ['food', 'toys', 'grooming', 'accessories'];
$basePath = 'public/assets/images';

foreach ($directories as $dir) {
    $fullDir = $basePath . '/' . $dir;
    if (!is_dir($fullDir)) continue;

    $files = scandir($fullDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $oldName = $fullDir . '/' . $file;
        $lowerFile = strtolower($file);
        $newName = $fullDir . '/' . $lowerFile;

        // Even if they look same on Windows, Git might see them differently
        // We force a move to a unique temp name first
        $tempName = $fullDir . '/temp_' . bin2hex(random_bytes(4)) . '_' . $file;

        echo "Processing: $file\n";
        
        // Use shell_exec to run git commands
        shell_exec("git mv \"$oldName\" \"$tempName\"");
        shell_exec("git mv \"$tempName\" \"$newName\"");
    }
}
echo "Git normalization complete. Please check 'git status'.\n";
