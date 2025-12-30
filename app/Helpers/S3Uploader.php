<?php

namespace App\Helpers;

use Aws\S3\S3Client;
use App\Models\DeveloperSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Exception;
use Throwable;

class S3Uploader
{
    /**
     * Get AWS configuration from Developer Settings
     */
    protected static function awsConfig(): array
    {
        return [
            'bucket' => config('filesystems.disks.s3.bucket'),
            'region' => config('filesystems.disks.s3.region'),
            'debug' => (bool) env('AWS_DEBUG', false),
        ];
    }

    /**
     * Build an AWS SDK S3Client using Developer Settings credentials
     */
    protected static function s3Client(): S3Client
    {
        $cfg = self::awsConfig();

        return new S3Client([
            'region' => $cfg['region'],
            'version' => 'latest',
            'credentials' => [
                'key' => $cfg['key'],
                'secret' => $cfg['secret'],
            ],
            'debug' => $cfg['debug'],
        ]);
    }

    /**
     * Build a public URL (virtual-hosted style)
     */
    public static function buildPublicUrl(string $key): string
    {
        $cfg = self::awsConfig();
        return "https://{$cfg['bucket']}.s3.{$cfg['region']}.amazonaws.com/{$key}";
    }

    /**
     * ------------------------------------------------------------
     * (A) DIRECT-TO-S3 UPLOAD (Presigned PUT URL)
     * ------------------------------------------------------------
     * Used by your JavaScript flow (browser uploads directly to S3)
     */
    public static function generatePresignedPutUrl(
        string $filename,
        string $type = 'application/octet-stream',
        string $folder,
    ): array {
        try {
            // 🔐 Sanitize filename
            $safeFilename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);

            // 📁 Build unique S3 key
            $key = trim($folder, '/')
                . '/' . Str::uuid()
                . '/' . $safeFilename;

            // ⚙️ AWS config from Laravel (env → config)
            $bucket = config('filesystems.disks.s3.bucket');

            if (!$bucket) {
                throw new \RuntimeException('S3 bucket is not configured.');
            }

            // ☁️ AWS SDK client
            $s3Client = new S3Client([
                'region' => config('filesystems.disks.s3.region'),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret'),
                ],
            ]);

            // 📝 Prepare PUT command
            $command = $s3Client->getCommand('PutObject', [
                'Bucket' => $bucket,
                'Key' => $key,
                'ContentType' => $type,
                // 'ACL' => 'public-read',
            ]);

            // ⏱️ Create presigned request (10 min)
            $signedRequest = $s3Client->createPresignedRequest(
                $command,
                '+10 minutes'
            );

            return [
                'upload_url' => (string) $signedRequest->getUri(),
                'key' => $key,
                'public_url' => self::buildPublicUrl($key),
            ];

        } catch (Throwable $e) {
            // ❌ Never fail silently at helper level
            \Log::error('S3 presigned PUT generation failed', [
                'filename' => $filename,
                'folder' => $folder,
                'error' => $e->getMessage(),
            ]);

            throw $e; // let controller handle response + SystemLogger
        }
    }


    /**
     * Delete an object by S3 key using AWS SDK
     * (Useful when you store the key and want an authoritative delete)
     */
    public static function deleteFile(string $key): bool
    {
        try {
            $cfg = self::awsConfig();
            $s3Client = self::s3Client();

            $s3Client->deleteObject([
                'Bucket' => $cfg['bucket'],
                'Key' => $key,
            ]);

            return true;
        } catch (Throwable $e) {
            Log::error("S3 file deletion failed: {$key}. Error: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * ------------------------------------------------------------
     * (B) SERVER-SIDE UPLOADS (Laravel Storage disk)
     * ------------------------------------------------------------
     * Used when Laravel receives the file (traditional upload)
     */

    /**
     * Upload ANY file (PDF, DOCX, ZIP, etc.) using Laravel Storage.
     * Returns the stored path (S3 key) NOT the full URL.
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
        $directory = trim($directory, '/');
        $path = $directory . '/' . $filename;

        Storage::disk($disk)->putFileAs($directory, $file, $filename);

        return $path;
    }

    /**
     * Upload IMAGE and convert to WebP using Intervention Image v3.
     * Returns the stored path (S3 key) NOT the full URL.
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

        if (!str_starts_with((string) $file->getMimeType(), 'image/')) {
            throw new Exception('Uploaded file is not a valid image.');
        }

        $filename = Str::uuid() . '.webp';
        $directory = trim($directory, '/');
        $path = $directory . '/' . $filename;

        $manager = new ImageManager(new Driver());

        try {
            $image = $manager
                ->read($file->getRealPath())
                ->orient()
                ->toWebp($quality);
        } catch (Throwable $e) {
            throw new Exception('Unable to process image file.');
        }

        Storage::disk($disk)->put(
            $path,
            (string) $image,
            [
                'ContentType' => 'image/webp',
                'Visibility' => 'public', // keep if you serve images publicly
            ]
        );

        return $path;
    }

    /**
     * Delete by path (S3 key) using Laravel Storage.
     * Safe no-op if null or doesn't exist.
     */
    public static function deletePath(?string $path, string $disk = 's3'): void
    {
        if (!$path) {
            return;
        }

        if (Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}
