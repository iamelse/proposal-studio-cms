<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Post;
use App\Models\PostViewStatistic;
use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardService
{
    public function getDashboardData(Authenticatable $user, string $range = '7d'): array
    {
        $isMaster = $user->role === RoleEnum::MASTER->value;
        $query = Post::query();

        if (! $isMaster) {
            $query->where('user_id', $user->id);
        }

        $viewsByDay = $this->getHistoricalViews($user, $isMaster, $range);
        $viewSummary = $this->getViewSummary($user, $isMaster, $range);
        $totalViews = $this->getTotalViews($query, $isMaster);
        $mostViewedPost = $this->getMostViewedPost($query, $isMaster);

        return [
            'title' => 'Dashboard',
            'isMaster' => $isMaster,
            'draftCount' => (clone $query)->where('status', PostStatus::DRAFT)->count(),
            'publishedCount' => (clone $query)->where('status', PostStatus::PUBLISHED)->count(),
            'totalCount' => (clone $query)->count(),
            'recentPosts' => (clone $query)->latest()->take(5)->get(),
            'postsThisMonth' => (clone $query)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'totalViews' => $totalViews,
            'mostViewedPost' => $mostViewedPost,
            'postsHistoricalViewsJson' => json_encode($viewsByDay),
            'viewSummary' => $viewSummary,
        ];
    }

    private function getTotalViews($postQuery, bool $isMaster): int
    {
        $postIds = (clone $postQuery)->pluck('id');
        return PostViewStatistic::whereIn('post_id', $postIds)->sum('views');
    }

    private function getMostViewedPost($postQuery, bool $isMaster): ?Post
    {
        $postIds = (clone $postQuery)->pluck('id');

        return Post::select('posts.*', DB::raw('SUM(pvs.views) as total_views'))
            ->join('post_view_statistics as pvs', 'pvs.post_id', '=', 'posts.id')
            ->whereIn('posts.id', $postIds)
            ->groupBy('posts.id')
            ->orderByDesc('total_views')
            ->first();
    }

    /**
     * Get historical post views based on dynamic range (e.g. 7d, 30d, 2m).
     */
    private function getHistoricalViews(Authenticatable $user, bool $isMaster, string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        $query = PostViewStatistic::select(
            'date',
            DB::raw('SUM(views) as total_views')
        )->where('date', '>=', $fromDate->toDateString());

        if (! $isMaster) {
            $postIds = Post::where('user_id', $user->id)->pluck('id');
            $query->whereIn('post_id', $postIds);
        }

        $rawViews = $query
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);

        return $dateRange->map(function ($date) use ($rawViews, $intervalType) {
            $isToday = $date->isToday();
            $label = $isToday
                ? 'Today'
                : ($intervalType === 'day' ? $date->format('D') : $date->format('M Y'));

            $match = $rawViews->first(function ($item) use ($date) {
                return Carbon::parse($item->date)->format('Y-m-d') === $date->format('Y-m-d');
            });

            return [
                'x' => $label,
                'y' => $match ? (int) $match->total_views : 0,
            ];
        })->all();
    }

    private function getViewSummary(Authenticatable $user, bool $isMaster, string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        $query = PostViewStatistic::select(
            'date',
            DB::raw('SUM(views) as total_views')
        )->where('date', '>=', $fromDate->toDateString());

        if (! $isMaster) {
            $postIds = Post::where('user_id', $user->id)->pluck('id');
            $query->whereIn('post_id', $postIds);
        }

        $data = $query->groupBy('date')->orderBy('date')->get();

        $totalViews = $data->sum('total_views');
        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);
        $days = $dateRange->count();

        $avgViews = $days > 0 ? round($totalViews / $days) : 0;

        $peakDay = $data->sortByDesc('total_views')->first()?->date;
        $peakDayLabel = $peakDay ? Carbon::parse($peakDay)->translatedFormat('l') : '-';

        return [
            'totalViews' => $totalViews,
            'avgViews' => $avgViews,
            'peakDay' => $peakDayLabel,
        ];
    }

    /**
     * Resolve time range (e.g. 7d, 30d, 2m) into Carbon and interval type.
     */
    private function resolveDateRange(string $range): array
    {
        if (str_ends_with($range, 'd')) {
            $days = (int) rtrim($range, 'd');
            return [now()->copy()->subDays($days - 1)->startOfDay(), 'day'];
        }

        if (str_ends_with($range, 'm')) {
            $months = (int) rtrim($range, 'm');
            return [now()->copy()->subMonths($months)->startOfMonth(), 'month'];
        }

        // Default to 7 days
        return [now()->copy()->subDays(6)->startOfDay(), 'day'];
    }

    /**
     * Generate date sequence based on type (daily or monthly).
     */
    private function generateDateRange(Carbon $from, Carbon $to, string $type): Collection
    {
        $dates = collect();
        $current = $from->copy();

        while ($current <= $to) {
            $dates->push($current->copy());
            $current->add($type === 'month' ? '1 month' : '1 day');
        }

        return $dates;
    }
}
