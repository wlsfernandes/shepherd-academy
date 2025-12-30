<?php

namespace App\Helpers;

use App\Models\Institution;
use Illuminate\Support\Str;
use RuntimeException;

class S3FolderGenerator
{
    /**
     * Build a safe, institution-scoped S3 folder.
     *
     * Input:
     *   $subfolder = "tasks/15/files"
     *
     * Output:
     *   institutions/gonzalez-center/tasks/15/files
     */
    /**
     * Build a safe, institution-scoped S3 folder
     * using the authenticated user's institution.
     *
     * Example:
     *   input:  "tasks/42/files"
     *   output: "gonzalez-center/tasks/42/files"
     */
    public static function createFolder(string $subfolder): string
    {
        $user = auth()->user()
            ?? throw new RuntimeException('Unauthenticated user.');

        $institution = $user->institution
            ?? throw new RuntimeException('User has no institution.');

        if (!filled($institution->name)) {
            throw new RuntimeException('Institution name is required.');
        }

        $subfolder = trim($subfolder, '/');

        if ($subfolder === '') {
            throw new RuntimeException('S3 subfolder cannot be empty.');
        }

        // 🔒 Stable + human-readable institution root
        $institutionSlug = Str::slug($institution->name);

        if (
            Str::startsWith($subfolder, $institutionSlug . '/')
            || $subfolder === $institutionSlug
        ) {
            return $subfolder;
        }

        return $institutionSlug . '/' . $subfolder;
    }

}
