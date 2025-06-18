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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($feature->image && Storage::disk('public')->exists($feature->image)) {
                return asset('storage/' . $feature->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $placeholderUrl = 'https://dummyimage.com/1080x1920';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        $image = is_array($content) ? ($content['image'] ?? null) : ($content->image ?? null);

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($image && Storage::disk('public')->exists($image)) {
                return asset('storage/' . $image);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                return asset('storage/' . $service->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($proposal->image && Storage::disk('public')->exists($proposal->image)) {
                return asset('storage/' . $proposal->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
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
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                return asset('storage/' . $event->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $filePath = $event->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($event->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

use Illuminate\Support\Facades\Log;

if (!function_exists('getPostCoverImagePath')) {
    function getPostCoverImagePath($post)
    {
        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';
        $placeholderUrl = 'https://picsum.photos/1200/600?random=' . ($post->id ?? 'null');

        Log::info('getPostCoverImagePath called', [
            'disk' => $disk,
            'post_id' => $post->id ?? null,
            'post_cover' => $post->cover ?? null,
        ]);

        if (!$post || !$post->cover) {
            Log::warning('Post or cover is missing, returning placeholder', [
                'post' => $post
            ]);
            return $placeholderUrl;
        }

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if (Storage::disk('public')->exists($post->cover)) {
                Log::info('Post cover found in public disk', [
                    'path' => $post->cover
                ]);
                return asset('storage/' . $post->cover);
            } else {
                Log::warning('Post cover not found in public disk', [
                    'path' => $post->cover
                ]);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $filePath = $post->cover;
            $fullPath = $publicHtmlPath . '/' . $filePath;

            if (file_exists($fullPath)) {
                Log::info('Post cover found in IDCLOUDHOST path', [
                    'full_path' => $fullPath
                ]);
                return $appUrl . '/' . $filePath;
            } else {
                Log::warning('Post cover not found in IDCLOUDHOST path', [
                    'full_path' => $fullPath
                ]);
            }
        }

        Log::info('Returning placeholder image for post cover', [
            'placeholder_url' => $placeholderUrl
        ]);

        return $placeholderUrl;
    }
}

if (!function_exists('getLogoImagePath')) {
    function getLogoImagePath($settings)
    {
        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';
        $placeholderUrl = asset('assets/images/logo.svg');

        if (!$settings || !$settings['site_logo']) {
            return $placeholderUrl;
        }

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if (Storage::disk('public')->exists($settings['site_logo'])) {
                return asset('storage/' . $settings['site_logo']);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $filePath = $settings['site_logo'];
            $fullPath = $publicHtmlPath . '/' . $filePath;

            if (file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getOgImageHomePath')) {
    function getOgImageHomePath($settings)
    {
        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';
        $placeholderUrl = 'https://picsum.photos/1200/600?random=32';

        if (!$settings || empty($settings['og_image_home'])) {
            return $placeholderUrl;
        }

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if (Storage::disk('public')->exists($settings['og_image_home'])) {
                return asset('storage/' . $settings['og_image_home']);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $filePath = $settings['og_image_home'];
            $fullPath = $publicHtmlPath . '/' . $filePath;

            if (file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}

if (!function_exists('getOgImagePostIndexPath')) {
    function getOgImagePostIndexPath($settings)
    {
        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = '/home/iamelsem/public_html/proposal-studio.iamelse.my.id';
        $placeholderUrl = 'https://picsum.photos/1200/600?random=33';

        if (!$settings || empty($settings['og_image_post_index'])) {
            return $placeholderUrl;
        }

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if (Storage::disk('public')->exists($settings['og_image_post_index'])) {
                return asset('storage/' . $settings['og_image_post_index']);
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $filePath = $settings['og_image_post_index'];
            $fullPath = $publicHtmlPath . '/' . $filePath;

            if (file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}
