<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateReviewRequest;
use App\Models\Section;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $review = Section::where('name', 'review')->firstOrFail();

        return view('pages.fe-home.review', [
            'title' => 'Home | Review',
            'review' => $review,
        ]);
    }

    public function update(UpdateReviewRequest $request)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_REVIEW->value);

            $validated = $request->validated();
            $content = $validated['content'];

            // Clean only 'title' and 'subtitle' HTML with restricted tags
            $rules = [
                'title'    => ['HTML.Allowed' => 'span[style]'],
            ];

            $cleanedContent = cleanHtmlFields($content, $rules);

            // Fetch the service section
            $section = Section::where('name', 'review')->firstOrFail();

            // Merge with existing content if needed
            $existingContent = json_decode($section->content, true) ?? [];

            // Keep other data if needed, or just overwrite
            $section->content = json_encode(array_merge($existingContent, $cleanedContent));
            $section->save();

            return redirect()->back()->with('success', 'Review section updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Failed to update Review section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update Review section. ' . $e->getMessage());
        }
    }
}
