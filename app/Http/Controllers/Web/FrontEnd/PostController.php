<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostViewStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $postCategories = PostCategory::all();
        $allowedFilterFields = ['title', 'slug', 'excerpt', 'body'];
        $posts = Post::with('category')->search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'published_at',
            sort_order: $request->sort_order ?? 'DESC'
        )->when($request->category, fn($query, $category) =>
            $query->whereHas('category', fn($q) => $q->where('slug', $category))
        )->where('status', PostStatus::PUBLISHED->value)
         ->paginate($request->query('limit') ?? 6);

        return view('pages.frontend.post.index', [
            'title' => 'Daftar Artikel',
            'postCategories' => $postCategories,
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        if ($post->status !== PostStatus::PUBLISHED->value) {
            abort(404);
        }

        $this->_incrementPostView($post);

        return view('pages.frontend.post.show', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }

    protected function _incrementPostView(Post $post): void
    {
        $today = now()->toDateString();

        PostViewStatistic::firstOrCreate(
            ['post_id' => $post->id, 'date' => $today],
            ['views' => 0]
        )->increment('views');
    }

    protected function _incrementDailyPostView(Post $post): void
    {
        $cookieKey = 'post_viewed_' . $post->id;
        $today = Carbon::today();

        // Sudah pernah dilihat hari ini? Lewati
        if (Cookie::has($cookieKey) && Cookie::get($cookieKey) === $today->toDateString()) {
            return;
        }

        // Tambah view hari ini
        PostViewStatistic::firstOrCreate(
            ['post_id' => $post->id, 'date' => $today->toDateString()],
            ['views' => 0]
        )->increment('views');

        // Simpan cookie berlaku 1 hari (1440 menit)
        Cookie::queue($cookieKey, $today->toDateString(), 1440);
    }
}
