<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;
class S3
{
    /**
     * Upload ANY file (PDF, DOCX, ZIP, etc.)
     * Returns the stored path (NOT URL)
     */
    public static function uploadFile(
        UploadedFile $file,
        string $directory,
        string $disk = 's3'
    ): string {
        if (!$file->isValid()) {
            throw new Exception('Invalid file upload.');
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = trim($directory, '/') . '/' . $filename;

        Storage::disk($disk)->putFileAs(
            $directory,
            $file,
            $filename
        );

        return $path;
    }

    /**
     * Upload IMAGE and convert to WebP
     * Returns the stored path (NOT URL)
     */
    public static function uploadImageAsWebp(
        UploadedFile $file,
        string $directory,
        int $quality = 85,
        string $disk = 's3'
    ): string {
        if (!$file->isValid()) {
            throw new Exception('Invalid image upload.');
        }

        $filename = Str::uuid() . '.webp';
        $path = trim($directory, '/') . '/' . $filename;

        // ✅ Create ImageManager (v3 way)
        $manager = new ImageManager(new Driver());

        $image = $manager
            ->read($file->getRealPath())
            ->toWebp($quality);

        Storage::disk($disk)->put(
            $path,
            (string) $image,
            [
                'ContentType' => 'image/webp',
            ]
        );

        return $path;
    }

    /**
     * Delete file from storage (by path)
     */
    public static function delete(
        ?string $path,
        string $disk = 's3'
    ): void {
        if (!$path) {
            return;
        }

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
