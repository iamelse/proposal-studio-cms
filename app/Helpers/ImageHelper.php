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

if (!function_exists('getServiceListImagePath')) {
    function getServiceListImagePath($service)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                return asset('storage/' . $service->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $service->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($service->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getProposalListImagePath')) {
    function getProposalListImagePath($proposal)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/400x600';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($proposal->image && Storage::disk('public')->exists($proposal->image)) {
                return asset('storage/' . $proposal->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $proposal->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($proposal->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getEventListImagePath')) {
    function getEventListImagePath($event)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/400x600';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                return asset('storage/' . $event->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $event->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($event->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getPostCoverImagePath')) {
    function getPostCoverImagePath($post)
    {
        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');
        $placeholderUrl = 'https://picsum.photos/1200/600?random=' . $post->id;

        if (!$post || !$post->cover) {
            return $placeholderUrl;
        }

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if (Storage::disk('public')->exists($post->cover)) {
                return asset('storage/' . $post->cover);
            }
        } elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $post->cover;
            $fullPath = $publicHtmlPath . '/' . $filePath;

            if (file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}
