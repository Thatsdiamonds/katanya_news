<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Convert and store an uploaded image as WebP.
     */
    public static function storeAsWebp(UploadedFile $file, string $folder = 'news-images', int $quality = 85): string
    {
        $filename = Str::random(40) . '.webp';
        $relativeDir = 'app/public/' . trim($folder, '/');
        $absoluteDir = storage_path($relativeDir);

        if (!file_exists($absoluteDir)) {
            mkdir($absoluteDir, 0755, true);
        }

        $targetPath = $absoluteDir . '/' . $filename;
        $mime = $file->getMimeType();
        $sourcePath = $file->getRealPath();

        $image = null;
        if (str_contains($mime, 'png')) {
            $image = @imagecreatefrompng($sourcePath);
            if ($image) {
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
            }
        } elseif (str_contains($mime, 'jpeg') || str_contains($mime, 'jpg')) {
            $image = @imagecreatefromjpeg($sourcePath);
        } elseif (str_contains($mime, 'webp')) {
            $image = @imagecreatefromwebp($sourcePath);
        } elseif (str_contains($mime, 'gif')) {
            $image = @imagecreatefromgif($sourcePath);
        }

        if ($image && function_exists('imagewebp')) {
            imagewebp($image, $targetPath, $quality);
            imagedestroy($image);
            return trim($folder, '/') . '/' . $filename;
        }

        // Fallback: store normally with original format if conversion fails
        return $file->store($folder, 'public');
    }
}
