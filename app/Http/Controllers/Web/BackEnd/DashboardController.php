<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Enums\PostStatus;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::READ_DASHBOARD->value);

        $user = Auth::user();
        $isMaster = $user->role === RoleEnum::MASTER->value;

        $query = Post::query();

        if (! $isMaster) {
            $query->where('user_id', $user->id);
        }

        return view('pages.dashboard.index', [
            'title' => 'Dashboard',
            'isMaster' => $isMaster,
            'draftCount' => (clone $query)->where('status', PostStatus::DRAFT)->count(),
            'publishedCount' => (clone $query)->where('status', PostStatus::PUBLISHED)->count(),
            'totalCount' => (clone $query)->count(),
            'recentPosts' => (clone $query)->latest()->take(5)->get(),
            'postsThisMonth' => (clone $query)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'totalViews' => (clone $query)->sum('views'),
            'mostViewedPost' => (clone $query)->orderByDesc('views')->first(),
        ]);
    }
}
