<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Event\StoreEventRequest;
use App\Http\Requests\Web\Event\UpdateEventRequest;
use App\Models\Event;
use App\Services\ImageManagementService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_EVENT->value);

        $allowedFilterFields = ['title'];
        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $events = Event::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'title',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.event.index', [
            'title' => 'Event',
            'events' => $events,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_EVENT);

        return view('pages.event.create', [
            'title'=> 'New Event',
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_EVENT);

            $imagePath = $this->_handleImageUpload($request, null);

            Event::create([
                'title' => $request->title,
                'image' => $imagePath
            ]);

            return redirect()->route('be.event.create')
                ->with('success','Event created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.event.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Event $event): View
    {
        Gate::authorize(PermissionEnum::UPDATE_EVENT);

        return view('pages.event.edit', [
            'title' => 'Edit Proposal',
            'proposal' => $event,
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_EVENT);

            $imagePath = $this->_handleImageUpload($request, $event);

            $event->update([
                'title' => $request->title,
                'image' => $imagePath ?? $event->image, // fallback to existing image
            ]);

            return redirect()->route('be.event.edit', $event->slug)
                ->with('success', 'Event updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.event.edit', $event->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Event $event): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_EVENT->value);

            $event->delete();
            $this->imageManagementService->destroyImage($event->image);

            return redirect()
                ->route('be.event.index')
                ->with('success', 'Event deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting event (Title: {$event->title}): " . $e->getMessage());

            return redirect()
                ->route('be.event.index')
                ->with('error', 'An error occurred while deleting the event.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_EVENT->value);

            $eventsArray = explode(',', $request->input('slugs', ''));

            if (!empty($eventsArray)) {
                $events = Event::whereIn('slug', $eventsArray)->get();

                foreach ($events as $event) {
                    $this->imageManagementService->destroyImage($event->image);
                }

                Event::whereIn('slug', $eventsArray)->delete();
            }

            return redirect()
                ->route('be.event.index')
                ->with('success', 'Events deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting events: ' . $e->getMessage());
            return redirect()
                ->route('be.event.index')
                ->with('error', 'An error occurred while deleting the events.');
        }
    }

    private function _handleImageUpload($request, $event)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = $event ? $event->image : null;

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $currentImagePath,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/events'
            ]);
        }

        return $imagePath;
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(Event::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
