<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\FAQ\StoreFAQRequest;
use App\Http\Requests\Web\FAQ\UpdateFAQRequest;
use App\Models\FAQ;
use App\Models\Review;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FAQController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_FAQ->value);

        $allowedFilterFields = ['question'];
        $allowedSortFields = ['question', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $faqs = FAQ::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'question',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.faq.index', [
            'title' => 'Frequently Asked Questions',
            'faqs' => $faqs,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_FAQ);

        return view('pages.faq.create', [
            'title'=> 'New FAQ',
        ]);
    }

    public function store(StoreFAQRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_FAQ);

            FAQ::create([
                'question'         => $request->question,
                'answer'       => $request->answer,
            ]);

            return redirect()->route('be.faq.create')
                ->with('success','FAQ created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.faq.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(FAQ $faq): View
    {
        Gate::authorize(PermissionEnum::UPDATE_FAQ);

        $faq = FAQ::findOrFail($faq->id);

        return view('pages.faq.edit', [
            'title' => 'Edit FAQ',
            'faq' => $faq,
        ]);
    }

    public function update(UpdateFAQRequest $request, FAQ $faq): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_FAQ);

            $faq->update([
                'question'         => $request->question,
                'answer'       => $request->answer,
            ]);

            return redirect()->route('be.faq.edit', $faq->id)
                ->with('success', 'FAQ updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.faq.edit', $faq->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(FAQ $faq): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_FAQ->value);

            $faq->delete();

            return redirect()
                ->route('be.faq.index')
                ->with('success', 'FAQ deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting faq (ID: {$faq->id}): " . $e->getMessage());

            return redirect()
                ->route('be.faq.index')
                ->with('error', 'An error occurred while deleting the faq.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_FAQ->value);

            $faqsArray = explode(',', $request->input('ids', ''));

            if (!empty($faqsArray)) {
                FAQ::whereIn('id', $faqsArray)->delete();
            }

            return redirect()
                ->route('be.faq.index')
                ->with('success', 'FAQs deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting FAQs: ' . $e->getMessage());
            return redirect()
                ->route('be.faq.index')
                ->with('error', 'An error occurred while deleting the FAQs.');
        }
    }
}
