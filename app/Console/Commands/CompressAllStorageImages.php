<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CompressAllStorageImages extends Command
{
    protected $signature = 'images:compress-all';
    protected $description = 'Compress all images in storage/app/public under 5KB without resizing';

    public function handle()
    {
        $basePath = storage_path('app/public');
        $targetSize = 5120; // 5KB

        $this->info("Scanning storage folder...");

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($basePath)
        );

        $compressedCount = 0;

        foreach ($files as $file) {

            if ($file->isDir()) continue;

            $filePath = $file->getPathname();
            $extension = strtolower($file->getExtension());

            // if (!in_array($extension, ['jpg', 'jpeg'])) continue;

            $currentSize = filesize($filePath);
            if ($currentSize <= $targetSize) continue;

            $source = imagecreatefromjpeg($filePath);
            if (!$source) continue;

            $quality = 70;

            do {
                ob_start();
                imagejpeg($source, null, $quality);
                $imageData = ob_get_clean();
                $quality -= 5;
            } while (strlen($imageData) > $targetSize && $quality > 5);

            file_put_contents($filePath, $imageData);
            imagedestroy($source);

            $compressedCount++;

            $this->info("Compressed: " . $filePath . " → " . round(strlen($imageData)/1024,2) . " KB");
        }

        if ($compressedCount > 0) {
            $this->info("Compression complete Total: $compressedCount images compressed.");
        } else {
            $this->warn("No images found to compress.");
        }
    }
}
