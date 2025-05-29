<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Feature\StoreFeatureRequest;
use App\Http\Requests\Web\Feature\UpdateFeatureRequest;
use App\Models\WhyUs;
use App\Services\ImageManagementService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_FEATURE->value);

        $allowedFilterFields = ['title'];
        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $features = WhyUs::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'title',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.feature.index', [
            'title' => 'Feature',
            'features' => $features,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_FEATURE);

        return view('pages.feature.create', [
            'title'=> 'New Feature',
        ]);
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_FEATURE);

            $imagePath = $this->_handleImageUpload($request, null);

            WhyUs::create([
                'title' => $request->title,
                'image' => $imagePath
            ]);

            return redirect()->route('be.feature.create')
                ->with('success','Skill created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.feature.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(WhyUs $feature): View
    {
        Gate::authorize(PermissionEnum::UPDATE_FEATURE);

        return view('pages.feature.edit', [
            'title' => 'Edit Feature',
            'feature' => $feature,
        ]);
    }

    public function update(UpdateFeatureRequest $request, WhyUs $feature): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_FEATURE);

            $imagePath = $this->_handleImageUpload($request, $feature);

            $feature->update([
                'title' => $request->title,
                'image' => $imagePath ?? $feature->image, // fallback to existing image
            ]);

            return redirect()->route('be.feature.edit', $feature->slug)
                ->with('success', 'Feature updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.feature.edit', $feature->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(WhyUs $feature): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_FEATURE->value);

            $feature->delete();
            $this->imageManagementService->destroyImage($feature->image);

            return redirect()
                ->route('be.feature.index')
                ->with('success', 'Feature deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting feature (Title: {$feature->title}): " . $e->getMessage());

            return redirect()
                ->route('be.feature.index')
                ->with('error', 'An error occurred while deleting the feature.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_FEATURE->value);

            $featuresArray = explode(',', $request->input('slugs', ''));

            if (!empty($featuresArray)) {
                $features = WhyUs::whereIn('slug', $featuresArray)->get();

                foreach ($features as $feature) {
                    $this->imageManagementService->destroyImage($feature->image);
                }

                WhyUs::whereIn('slug', $featuresArray)->delete();
            }

            return redirect()
                ->route('be.feature.index')
                ->with('success', 'Features deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting features: ' . $e->getMessage());
            return redirect()
                ->route('be.feature.index')
                ->with('error', 'An error occurred while deleting the features.');
        }
    }

    private function _handleImageUpload($request, $feature)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = $feature ? $feature->image : null;

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $currentImagePath,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/features'
            ]);
        }

        return $imagePath;
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(WhyUs::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
