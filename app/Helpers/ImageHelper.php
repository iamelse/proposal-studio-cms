<?php

use App\Enums\FileSystemDiskEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getUserImageProfilePath')) {
    function getUserImageProfilePath($user)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $avatar = Avatar::create(Auth::user()->name);
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $user->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($user->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $avatar->toBase64();
    }
}

if (!function_exists('getAuthorPostImagePath')) {
    function getAuthorPostImagePath($user)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $avatar = Avatar::create($user->name ?? $user->full_name ?? 'User');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $user->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($user->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $avatar->toBase64();
    }
}

if (!function_exists('getWhyUsListImagePath')) {
    function getWhyUsListImagePath($feature)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($feature->image && Storage::disk('public')->exists($feature->image)) {
                return asset('storage/' . $feature->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $feature->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($feature->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getAboutUsImageSection')) {
    function getAboutUsImageSection($content)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        $image = is_array($content) ? ($content['image'] ?? null) : ($content->image ?? null);

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($image && Storage::disk('public')->exists($image)) {
                return asset('storage/' . $image);
            }
        } elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $fullPath = $publicHtmlPath . '/' . $image;
            if ($image && file_exists($fullPath)) {
                return $appUrl . '/' . $image;
            }
        }

        return $placeholderUrl;
    }
}
