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
        return '../public_html/' . $folder;
    }

    public function uploadImage(UploadedFile $file, array $options = [])
    {
        $currentImagePath = $options['currentImagePath'] ?? null;
        $disk = $options['disk'] ?? FileSystemDiskEnum::PUBLIC->value;
        $folder = $options['folder'] ?? null;
        $postTitle = $options['postTitle'] ?? null;

        $fileName = $this->generateFileName($file, $postTitle);
        logger()->info("Uploading image. Disk: $disk, Folder: $folder, FileName: $fileName");

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                logger()->info("Deleting existing image from 'public' disk: $currentImagePath");
                Storage::disk('public')->delete($currentImagePath);
            }

            $path = ($folder ? "$folder/" : '') . $fileName;
            Storage::disk('public')->putFileAs($folder, $file, $fileName);
            logger()->info("Image uploaded to 'public' disk at path: $path");

            return $path;

        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $directory = $this->publicUploadsPath($folder);
            logger()->info("IDCLOUDHOST path resolved to: $directory");

            if (!File::exists($directory)) {
                try {
                    File::makeDirectory($directory, 0755, true);
                    logger()->info("Directory created: $directory");
                } catch (\Exception $e) {
                    logger()->error("Failed to create directory: $directory - " . $e->getMessage());
                }
            }

            if ($currentImagePath) {
                $existingPath = $this->publicUploadsPath($currentImagePath);
                if (File::exists($existingPath)) {
                    logger()->info("Deleting existing image from IDCLOUDHOST path: $existingPath");
                    File::delete($existingPath);
                } else {
                    logger()->warning("Tried to delete non-existing file: $existingPath");
                }
            }

            try {
                $file->move($directory, $fileName);
                logger()->info("File moved to: $directory/$fileName");
                return $folder . '/' . $fileName;
            } catch (\Exception $e) {
                logger()->error("Failed to move file to: $directory - " . $e->getMessage());
            }
        }

        logger()->warning("No valid disk selected for image upload.");
        return null;
    }

    public function destroyImage($currentImagePath, $disk = FileSystemDiskEnum::PUBLIC->value)
    {
        logger()->info("Destroying image at: $currentImagePath using disk: $disk");

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
                logger()->info("Image deleted from 'public' disk: $currentImagePath");
                return true;
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $fullPath = $this->publicUploadsPath($currentImagePath);
            if ($currentImagePath && File::exists($fullPath)) {
                File::delete($fullPath);
                logger()->info("Image deleted from IDCLOUDHOST path: $fullPath");
                return true;
            } else {
                logger()->warning("File to delete does not exist: $fullPath");
            }
        }

        logger()->warning("Image not deleted. Path may be missing or disk invalid.");
        return false;
    }

    protected function generateFileName(UploadedFile $file, ?string $contextName = null): string
    {
        $name = $contextName
            ? Str::slug($contextName)
            : Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        $extension = $file->getClientOriginalExtension();

        return $name . '-' . time() . '.' . strtolower($extension);
    }
}
