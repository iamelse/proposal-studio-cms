<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateAboutRequest;
use App\Models\Section;
use App\Services\ImageManagementService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_ABOUT->value);

        $about = Section::where('name', 'about')->firstOrFail();

        return view('pages.fe-home.about', [
            'title' => 'Home | About Us',
            'about' => $about
        ]);
    }

    public function update(UpdateAboutRequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_ABOUT->value);

            $validated = $request->validated();
            $content = $validated['content'];

            $rules = [
                'title'       => ['HTML.Allowed' => 'span[style]'],  // Only <span> with style
                'description' => [
                    'HTML.Allowed' => 'span[style],p[style],strong,em,u,br',
                    'CSS.AllowedProperties' => 'color,text-align',
                ],
            ];

            $cleanedContent = cleanHtmlFields($content, $rules);

            $section = Section::where('name', 'about')->firstOrFail();

            $existingContent = json_decode($section->content, true) ?? [];

            $cleanedContent['image'] = $this->_handleImageUpload($request, $section)
                ?? ($existingContent['image'] ?? null);

            $section->content = json_encode($cleanedContent);
            $section->save();

            return redirect()->back()->with('success', 'About section updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update About section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update About section. ' . $e->getMessage());
        }
    }

    private function _handleImageUpload($request, $section)
    {
        if ($request->hasFile('content.image')) {
            $image = $request->file('content.image');

            return $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => json_decode($section->content, true)['image'] ?? null,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/home'
            ]);
        }

        return null;
    }
}
