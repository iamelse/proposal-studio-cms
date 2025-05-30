<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Service\StoreOurServiceRequest;
use App\Http\Requests\Web\Service\UpdateOurServiceRequest;
use App\Models\Service;
use App\Services\ImageManagementService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OurServiceListController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_OUR_SERVICE->value);

        $allowedFilterFields = ['title'];
        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $services = Service::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'title',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.service.index', [
            'title' => 'Service List',
            'services' => $services,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_OUR_SERVICE);

        return view('pages.our-service-list.create', [
            'title' => 'New Service',
        ]);
    }

    public function store(StoreOurServiceRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_OUR_SERVICE);

            $imagePath = $this->_handleImageUpload($request, null);

            Service::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath
            ]);

            return redirect()->route('be.our-service-list.create')
                ->with('success', 'Service created successfully.');
        } catch (AuthorizationException $e) {
            Log::error($e->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('be.our-service-list.create')
                ->with('error', $e->getMessage());
        }
    }

    public function edit(Service $service): View
    {
        Gate::authorize(PermissionEnum::UPDATE_OUR_SERVICE);

        return view('pages.our-service-list.edit', [
            'title' => 'Edit Service',
            'service' => $service,
        ]);
    }

    public function update(UpdateOurServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_OUR_SERVICE);

            $imagePath = $this->_handleImageUpload($request, $service);

            $service->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath ?? $service->image,
            ]);

            return redirect()->route('be.our-service-list.edit', $service->slug)
                ->with('success', 'Service updated successfully.');
        } catch (AuthorizationException $e) {
            Log::error($e->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('be.our-service-list.edit', $service->slug)
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(Service $service): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_OUR_SERVICE->value);

            $service->delete();
            $this->imageManagementService->destroyImage($service->image);

            return redirect()
                ->route('be.our-service-list.index')
                ->with('success', 'Service deleted successfully.');
        } catch (AuthorizationException $e) {
            Log::error($e->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting service (Title: {$service->title}): " . $e->getMessage());
            return redirect()
                ->route('be.our-service-list.index')
                ->with('error', 'An error occurred while deleting the service.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_OUR_SERVICE->value);

            $slugs = explode(',', $request->input('slugs', ''));

            if (!empty($slugs)) {
                $services = Service::whereIn('slug', $slugs)->get();

                foreach ($services as $service) {
                    $this->imageManagementService->destroyImage($service->image);
                }

                Service::whereIn('slug', $slugs)->delete();
            }

            return redirect()
                ->route('be.our-service-list.index')
                ->with('success', 'Services deleted successfully.');
        } catch (AuthorizationException $e) {
            Log::error($e->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting services: ' . $e->getMessage());
            return redirect()
                ->route('be.our-service-list.index')
                ->with('error', 'An error occurred while deleting the services.');
        }
    }

    private function _handleImageUpload($request, $service)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = $service ? $service->image : null;

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $currentImagePath,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/services'
            ]);
        }

        return $imagePath;
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(Service::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
