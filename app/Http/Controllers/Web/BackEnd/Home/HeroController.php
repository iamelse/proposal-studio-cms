<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateHeroRequest;
use App\Models\Section;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_HERO->value);

        $hero = Section::where('name', 'hero')->firstOrFail();

        return view('pages.fe-home.hero', [
            'title' => 'Home | Hero',
            'hero' => $hero
        ]);
    }

    public function update(UpdateHeroRequest $request, Section $section)
    {
        try {
            // Authorization check
            Gate::authorize(PermissionEnum::UPDATE_HOME_HERO->value);

            // Validate and get content input
            $validated = $request->validated();
            $content = $validated['content'];

            // Define purifier rules per field
            $rules = [
                'title'    => ['HTML.Allowed' => 'span[style]'],  // Only <span> with style attribute
                'description' => ['HTML.Allowed' => 'span[style]'],
            ];

            // Sanitize content fields according to rules
            $cleanedContent = cleanHtmlFields($content, $rules);

            // Find the section named 'hero' (override injected $section if needed)
            $section = Section::where('name', 'hero')->firstOrFail();

            // Store sanitized JSON content
            $section->content = json_encode($cleanedContent);
            $section->save();

            return redirect()->back()->with('success', 'Hero section updated successfully.');

        } catch (AuthorizationException $authEx) {
            Log::error('Unauthorized action: ' . $authEx->getMessage());
            abort(403, 'This action is unauthorized.');

        } catch (Exception $ex) {
            Log::error('Failed to update Hero section', [
                'error'        => $ex->getMessage(),
                'trace'        => $ex->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id'      => Auth::id(),
            ]);

            return redirect()->back()->with('error', 'Failed to update Hero section. ' . $ex->getMessage());
        }
    }
}
