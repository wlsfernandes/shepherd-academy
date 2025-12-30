<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('auth_institution_id')) {
    function auth_institution_id(): ?int
    {
        $user = Auth::user();

        return $user?->institution_id;
    }
}
