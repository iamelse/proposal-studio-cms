<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Post\StorePostRequest;
use App\Http\Requests\Web\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\ImageManagementService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected ImageManagementService $imageManagementService
    ) {}

    protected array $allowedFilterFields = ['title', 'slug', 'body'];

    private function _getFilteredPosts(Request $request)
    {
        return Post::with('category')
            ->search(
                keyword: $request->keyword,
                columns: $this->allowedFilterFields,
            )
            ->sort(
                sort_by: $request->sort_by ?? 'created_at',
                sort_order: $request->sort_order ?? 'DESC'
            )
            ->when($request->category, fn($query, $category) =>
            $query->whereHas('category', fn($q) => $q->where('slug', $category))
            )
            ->when($request->status, fn($query, $status) =>
            $query->where('status', $status)
            )
            ->paginate($request->query('limit') ?? 10);
    }

    public function index(Request $request): View
    {
        Gate::authorize(PermissionEnum::READ_POST->value);

        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];
        $postCategories = PostCategory::all();

        $posts = $this->_getFilteredPosts($request);

        return view('pages.post.index', [
            'title' => 'Post',
            'posts' => $posts,
            'allowedFilterFields' => $this->allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits,
            'postCategories' => $postCategories
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_POST->value);

        $postCategories = PostCategory::all();

        return view('pages.post.create', [
            'title' => 'Create Post',
            'postCategories' => $postCategories,
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::CREATE_POST->value);

        try {
            $imagePath = $this->_handleImageUpload($request, null);

            $data = $request->validated();

            if ($imagePath) {
                $data['cover'] = $imagePath;
            }

            if ($data['status'] === 'published') {
                $data['user_id'] ??= auth()->id();
                $data['published_at'] ??= now();
            }

            Post::create($data);

            return redirect()->route('be.post.index')
                ->with('success', 'Post created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        }
    }

    public function edit(Post $post): View
    {
        Gate::authorize(PermissionEnum::UPDATE_POST->value);

        $postCategories = PostCategory::all();

        return view('pages.post.edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'postCategories' => $postCategories,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize(PermissionEnum::UPDATE_POST->value);

        try {
            $imagePath = $this->_handleImageUpload($request, $post);

            $post->update([
                'title'         => $request->title,
                'slug'          => $request->slug,
                'excerpt'       => $request->excerpt,
                'body'          => $request->body,
                'status'        => $request->status,
                'category_id'   => $request->category_id,
                'user_id'       => $request->status === 'published'
                    ? ($request->user_id ?? auth()->id())
                    : $post->user_id,
                'published_at'  => $request->status === 'published'
                    ? ($request->published_at ?? now())
                    : $post->published_at,
                'cover'         => $imagePath ?? $post->cover, // fallback to existing cover
            ]);

            return redirect()->route('be.post.edit', $post->slug)
                ->with('success', 'Post updated successfully.');

        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('be.post.edit', $post->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST->value);

        try {
            $post->delete();
            $this->imageManagementService->destroyImage($post->cover);

            return redirect()
                ->route('be.post.index')
                ->with('success', 'Post deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting post (slug: {$post->slug}): " . $e->getMessage());

            return redirect()
                ->route('be.post.index')
                ->with('error', 'An error occurred while deleting the post.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST->value);

        try {
            $postSlugArray = explode(',', $request->input('slugs', ''));

            if (!empty($postSlugArray)) {
                $posts = Post::whereIn('slug', $postSlugArray)->get();

                // Hapus gambar satu per satu
                foreach ($posts as $post) {
                    $this->imageManagementService->destroyImage($post->cover);
                }

                // Hapus semua post setelah gambar berhasil dihapus
                Post::whereIn('slug', $postSlugArray)->delete();
            }

            return redirect()
                ->route('be.post.index')
                ->with('success', 'Posts deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting posts: ' . $e->getMessage());

            return redirect()
                ->route('be.post.index')
                ->with('error', 'An error occurred while deleting the posts.');
        }
    }

    private function _handleImageUpload($request, $post)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $currentImagePath = $post?->cover;
            $postTitle = $post?->title ?? $request->title;

            $imagePath = $this->imageManagementService->uploadImage($image, [
                'currentImagePath' => $currentImagePath,
                'disk' => env('FILESYSTEM_DISK'),
                'folder' => 'uploads/posts',
                'postTitle' => $postTitle
            ]);
        }

        return $imagePath;
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
