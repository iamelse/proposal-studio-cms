<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostViewStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        $today = Carbon::today()->toDateString();

        $stat = PostViewStatistic::firstOrCreate(
            ['post_id' => $post->id, 'date' => $today],
            ['views' => 0]
        );

        $stat->increment('views');


        return view('pages.frontend.post.show', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }
}
