<?php

namespace App\Services;

use App\Enums\FileSystemDiskEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManagementService
{
    protected function publicUploadsPath($folder = '')
    {
        return '../public_html/proposal-studio/' . $folder;
    }

    public function uploadImage(UploadedFile $file, array $options = [])
    {
        $currentImagePath = $options['currentImagePath'] ?? null;
        $disk = $options['disk'] ?? FileSystemDiskEnum::PUBLIC->value;
        $folder = $options['folder'] ?? null;
        $postTitle = $options['postTitle'] ?? null;

        $fileName = $this->generateFileName($file, $postTitle);

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
            }

            $path = ($folder ? "$folder/" : '') . $fileName;
            Storage::disk('public')->putFileAs($folder, $file, $fileName);

            return $path;

        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $directory = $this->publicUploadsPath($folder);

            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            if ($currentImagePath && File::exists($this->publicUploadsPath($currentImagePath))) {
                File::delete($this->publicUploadsPath($currentImagePath));
            }

            $file->move($directory, $fileName);
            return $folder . '/' . $fileName;
        }

        return null;
    }

    public function destroyImage($currentImagePath, $disk = FileSystemDiskEnum::PUBLIC->value)
    {
        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
                return true;
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            if ($currentImagePath && File::exists($this->publicUploadsPath($currentImagePath))) {
                File::delete($this->publicUploadsPath($currentImagePath));
                return true;
            }
        }

        return false;
    }

    protected function generateFileName(UploadedFile $file, ?string $contextName = null): string
    {
        $name = $contextName
            ? Str::slug($contextName) // SEO slug dari contextName
            : Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)); // slug dari nama file asli

        $extension = $file->getClientOriginalExtension();

        return $name . '-' . time() . '.' . strtolower($extension);
    }
}
