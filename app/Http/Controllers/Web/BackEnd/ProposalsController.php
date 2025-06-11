<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Proposal\StoreProposalRequest;
use App\Http\Requests\Web\Proposal\UpdateProposalRequest;
use App\Models\Proposal;
use App\Services\ImageManagementService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProposalsController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_PROPOSAL->value);

        $allowedFilterFields = ['title'];
        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $proposals = Proposal::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'title',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.proposal.index', [
            'title' => 'Proposal',
            'proposals' => $proposals,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_PROPOSAL);

        return view('pages.proposal.create', [
            'title'=> 'New Proposal',
        ]);
    }

    public function store(StoreProposalRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_PROPOSAL);

            $imagePath = $this->_handleImageUpload($request, null);

            Proposal::create([
                'title' => $request->title,
                'image' => $imagePath
            ]);

            return redirect()->route('be.proposal.create')
                ->with('success','Proposal created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.proposal.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Proposal $proposal): View
    {
        Gate::authorize(PermissionEnum::UPDATE_PROPOSAL);

        return view('pages.proposal.edit', [
            'title' => 'Edit Proposal',
            'proposal' => $proposal,
        ]);
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_PROPOSAL);

            $imagePath = $this->_handleImageUpload($request, $proposal);

            $proposal->update([
                'title' => $request->title,
                'image' => $imagePath ?? $proposal->image, // fallback to existing image
            ]);

            return redirect()->route('be.proposal.edit', $proposal->slug)
                ->with('success', 'Proposal updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.proposal.edit', $proposal->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Proposal $proposal): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_PROPOSAL->value);

            $proposal->delete();
            $this->imageManagementService->destroyImage($proposal->image);

            return redirect()
                ->route('be.proposal.index')
                ->with('success', 'Proposal deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting proposal (Title: {$proposal->title}): " . $e->getMessage());

            return redirect()
                ->route('be.proposal.index')
                ->with('error', 'An error occurred while deleting the proposal.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_PROPOSAL->value);

            $proposalsArray = explode(',', $request->input('slugs', ''));

            if (!empty($proposalsArray)) {
                $proposals = Proposal::whereIn('slug', $proposalsArray)->get();

                foreach ($proposals as $proposal) {
                    $this->imageManagementService->destroyImage($proposal->image);
                }

                Proposal::whereIn('slug', $proposalsArray)->delete();
            }

            return redirect()
                ->route('be.proposal.index')
                ->with('success', 'Proposals deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting proposals: ' . $e->getMessage());
            return redirect()
                ->route('be.proposal.index')
                ->with('error', 'An error occurred while deleting the proposals.');
        }
    }

    private function _handleImageUpload($request, $proposal)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = $proposal ? $proposal->image : null;

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $currentImagePath,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/proposals'
            ]);
        }

        return $imagePath;
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(Proposal::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
