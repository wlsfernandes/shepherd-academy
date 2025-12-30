<?php

namespace App\Http\Controllers;

use App\Helpers\S3Uploader;
use App\Helpers\S3FolderGenerator;
use App\Services\SystemLogger;
use Illuminate\Http\Request;
use Throwable;

class AmazonS3Controller extends BaseController
{
    /**
     * Generate a presigned PUT URL for direct browser → S3 upload.
     *
     * Flow:
     * 1. Frontend requests presigned URL
     * 2. Laravel validates intent
     * 3. AWS SDK generates signed PUT URL
     * 4. Browser uploads file directly to S3
     */

    public function generatePresignedUrl(Request $request)
    {
        $validated = $request->validate([
            'filename' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'folder' => 'required|string|max:255', // 👈 REQUIRED now
        ]);

        try {
            $user = auth()->user()
                ?? throw new \RuntimeException('Unauthenticated request.');

            $filename = $validated['filename'];
            $type = $validated['type'] ?? 'application/octet-stream';

            // ✅ Enforce institution root + your existing subfolder logic
            $folder = S3FolderGenerator::createFolder($validated['folder']);

            // 🔐 Delegate AWS logic to uploader
            $s3 = S3Uploader::generatePresignedPutUrl(
                $filename,
                $type,
                $folder
            );

            // 🛡️ Defensive contract enforcement
            foreach (['upload_url', 'key', 'public_url'] as $required) {
                if (!array_key_exists($required, $s3)) {
                    throw new \RuntimeException("Missing S3 response key: {$required}");
                }
            }

            // 📘 System log (success)
            SystemLogger::log(
                'S3 presigned URL generated',
                'info',
                's3.presign',
                [
                    'user' => $user->email,
                    'filename' => $filename,
                    'folder' => $folder,
                    'key' => $s3['key'],
                ]
            );

            return response()->json([
                'success' => true,
                'upload_url' => $s3['upload_url'],
                'key' => $s3['key'],
                'public_url' => $s3['public_url'],
            ]);

        } catch (Throwable $e) {

            // 🔴 System log (failure)
            SystemLogger::log(
                'Failed to generate S3 presigned URL',
                'error',
                's3.presign',
                [
                    'user' => auth()->user()?->email,
                    'filename' => $validated['filename'] ?? null,
                    'folder' => $validated['folder'] ?? null,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            return response()->json([
                'success' => false,
                'message' => 'Unable to generate upload URL.',
            ], 500);
        }
    }

}
