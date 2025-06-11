<?php

namespace App\Http\Controllers\Web\BackEnd\Setting;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Settings\UpdateGeneralSettingRequest;
use App\Models\Setting;
use App\Services\ImageManagementService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GeneralSettingController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    )
    {
    }

    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_SETTING_GENERAL->value);

        $setting = Setting::pluck('value', 'key');

        return view('pages.settings.general.index', [
            'title' => 'Setting',
            'setting' => $setting,
        ]);
    }

    public function update(UpdateGeneralSettingRequest $request)
    {
        try {
            $imageKeys = ['site_logo', 'og_image_home', 'og_image_post_index'];

            // Ambil semua settings dari request
            $allSettings = $request->input('settings', []);

            // Ambil hasil upload gambar
            $uploadedImages = $this->_handleImageUpload($request, $imageKeys);

            // Filter teks (non-image)
            $textSettings = collect($allSettings)
                ->except($imageKeys)
                ->toArray();

            // Gabungkan semuanya
            $settings = array_merge($textSettings, $uploadedImages);

            // Simpan ke database
            foreach ($settings as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return redirect()->back()->with('success', 'General settings updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error('Authorization failed for updating general settings', [
                'user_id' => Auth::id(),
                'error' => $authorizationException->getMessage()
            ]);
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Failed to update general settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Failed to update general settings. ' . $e->getMessage());
        }
    }

    private function _handleImageUpload($request, array $imageKeys): array
    {
        $uploadedPaths = [];

        foreach ($imageKeys as $key) {
            if ($request->hasFile("settings.$key")) {
                $image = $request->file("settings.$key");

                // Ambil path lama dari database jika ada
                $existingSetting = Setting::where('key', $key)->first();
                $oldPath = $existingSetting?->value;

                // Upload file baru
                $uploadedPath = $this->imageManagementService->uploadImage($image, [
                    'disk' => env('FILESYSTEM_DISK'),
                    'folder' => "uploads/settings/$key",
                    'currentImagePath' => $oldPath,
                ]);

                // Hapus file lama (opsional, tergantung logika destroyImage)
                if ($oldPath && $oldPath !== $uploadedPath) {
                    $this->imageManagementService->destroyImage($oldPath);
                }

                $uploadedPaths[$key] = $uploadedPath;
            }
        }

        return $uploadedPaths;
    }
}
