<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Review\StoreReviewRequest;
use App\Http\Requests\Web\Review\UpdateReviewRequest;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_REVIEW->value);

        $allowedFilterFields = ['name', 'rating', 'comment', 'company_name'];
        $allowedSortFields = ['name', 'rating', 'company_name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $reviews = Review::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'name',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.review.index', [
            'title' => 'Reviews',
            'reviews' => $reviews,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_REVIEW);

        return view('pages.review.create', [
            'title'=> 'New Review',
        ]);
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_REVIEW);

            $generatedImage = "https://ui-avatars.com/api/?name=" . urlencode($request->name) . "&background=random";

            Review::create([
                'name'         => $request->name,
                'rating'       => $request->rating,
                'comment'      => $request->comment,
                'company_name' => $request->company_name,
                'image'        => $generatedImage
            ]);

            return redirect()->route('be.review.create')
                ->with('success','Review created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.review.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(Review $review): View
    {
        Gate::authorize(PermissionEnum::UPDATE_REVIEW);

        $review = Review::findOrFail($review->id);

        return view('pages.review.edit', [
            'title' => 'Edit Review',
            'review' => $review,
        ]);
    }

    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_REVIEW);

            $generatedImage = "https://ui-avatars.com/api/?name=" . urlencode($request->name) . "&background=random";

            $review->update([
                'name'         => $request->name,
                'rating'       => $request->rating,
                'comment'      => $request->comment,
                'company_name' => $request->company_name,
                'image'        => $generatedImage
            ]);

            return redirect()->route('be.review.edit', $review->id)
                ->with('success', 'Review updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.review.edit', $review->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Review $review): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_REVIEW->value);

            $review->delete();

            return redirect()
                ->route('be.review.index')
                ->with('success', 'Review deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting review (Title: {$review->name}): " . $e->getMessage());

            return redirect()
                ->route('be.review.index')
                ->with('error', 'An error occurred while deleting the review.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_REVIEW->value);

            $reviewsArray = explode(',', $request->input('ids', ''));

            if (!empty($reviewsArray)) {
                Review::whereIn('id', $reviewsArray)->delete();
            }

            return redirect()
                ->route('be.review.index')
                ->with('success', 'Reviews deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting reviews: ' . $e->getMessage());
            return redirect()
                ->route('be.review.index')
                ->with('error', 'An error occurred while deleting the reviews.');
        }
    }
}
