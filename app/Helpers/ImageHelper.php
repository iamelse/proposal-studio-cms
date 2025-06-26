<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;

/*------------------------------------------------------------------
|  FUNGSI GENERIK
|-----------------------------------------------------------------*/

/**
 * Kembalikan URL file di disk default, atau placeholder bila tak ada.
 */
if (!function_exists('storage_image_url')) {
    function storage_image_url(?string $path, string $placeholder): string
    {
        $disk = config('filesystems.default');      // <-- aman untuk config:cache

        return $path && Storage::disk($disk)->exists($path)
            ? Storage::disk($disk)->url($path)
            : $placeholder;
    }
}

/**
 * Base-64 avatar sederhana.
 */
if (!function_exists('avatar_placeholder')) {
    function avatar_placeholder(string $name): string
    {
        return Avatar::create(Str::limit($name, 50))->toBase64();
    }
}

/*------------------------------------------------------------------
|  HELPER SPESIFIK
|-----------------------------------------------------------------*/

function getUserImageProfilePath($user): string
{
    return $user?->image && Storage::disk(config('filesystems.default'))->exists($user->image)
        ? Storage::disk(config('filesystems.default'))->url($user->image)
        : avatar_placeholder($user?->name ?? 'User');
}

function getAuthorPostImagePath($user): string
{
    return getUserImageProfilePath($user);
}

function getWhyUsListImagePath($feature): string
{
    return storage_image_url($feature->image ?? null, 'https://dummyimage.com/300');
}

function getAboutUsImageSection($content): string
{
    $image = is_array($content) ? ($content['image'] ?? null) : ($content->image ?? null);
    return storage_image_url($image, 'https://dummyimage.com/1080x1920');
}

function getServiceListImagePath($service): string
{
    return storage_image_url($service->image ?? null, 'https://dummyimage.com/300');
}

function getProposalListImagePath($proposal): string
{
    return storage_image_url($proposal->image ?? null, 'https://dummyimage.com/400x600');
}

function getEventListImagePath($event): string
{
    return storage_image_url($event->image ?? null, 'https://dummyimage.com/400x600');
}

function getPostCoverImagePath($post): string
{
    $placeholder = 'https://picsum.photos/1200/600?random=' . ($post->id ?? 'null');
    return storage_image_url($post->cover ?? null, $placeholder);
}

function getLogoImagePath($settings): string
{
    return storage_image_url($settings['site_logo'] ?? null, asset('assets/images/logo.svg'));
}

function getOgImageHomePath($settings): string
{
    return storage_image_url($settings['og_image_home'] ?? null, 'https://picsum.photos/1200/600?random=32');
}

function getOgImagePostIndexPath($settings): string
{
    return storage_image_url($settings['og_image_post_index'] ?? null, 'https://picsum.photos/1200/600?random=33');
}
