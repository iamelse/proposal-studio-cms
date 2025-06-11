<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateProposalRequest;
use App\Models\Section;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_PROPOSAL->value);

        $proposal = Section::where('name', 'proposal')->firstOrFail();

        return view('pages.fe-home.proposal', [
            'title' => 'Home | Proposal',
            'proposal' => $proposal,
        ]);
    }

    public function update(UpdateProposalRequest $request)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_PROPOSAL->value);

            $validated = $request->validated();
            $content = $validated['content'];

            // Clean only 'title' and 'subtitle' HTML with restricted tags
            $rules = [
                'title'    => ['HTML.Allowed' => 'span[style]'],
                'subtitle' => ['HTML.Allowed' => 'span[style]'],
            ];

            $cleanedContent = cleanHtmlFields($content, $rules);

            // Fetch the service section
            $section = Section::where('name', 'proposal')->firstOrFail();

            // Merge with existing content if needed
            $existingContent = json_decode($section->content, true) ?? [];

            // Keep other data if needed, or just overwrite
            $section->content = json_encode(array_merge($existingContent, $cleanedContent));
            $section->save();

            return redirect()->back()->with('success', 'Proposal section updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Failed to update Proposal section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update Proposal section. ' . $e->getMessage());
        }
    }
}
