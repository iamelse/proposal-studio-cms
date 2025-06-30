<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\Post;
use App\Models\PostViewStatistic;
use App\Enums\PostStatus;
use App\Models\VisitorStatistic;
use App\Models\WhatsappClickStatistic;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class DashboardService
{
    public function getDashboardData(Authenticatable $user, string $range = '7d'): array
    {
        $isMaster = $user->role === RoleEnum::MASTER->value;
        $postQuery = Post::query();

        if (!$isMaster) {
            $postQuery->where('user_id', $user->id);
        }

        // Post statistics
        $postViewsByDay = $this->getPostViewHistory($user, $isMaster, $range);
        $postViewSummary = $this->summarizePostViews($user, $isMaster, $range);
        $totalPostViews = $this->calculateTotalPostViews($postQuery, $isMaster);
        $mostViewedPost = $this->getTopViewedPost($postQuery, $isMaster);

        // Website visitor statistics
        $websiteVisitorStats = $this->getWebsiteVisitorHistory($range);
        $websiteVisitorSummary = $this->summarizeWebVisitors($range);

        $whatsappClickStats = $this->getWhatsappClickHistory($range);
        $whatsappClickSummary  = $this->summarizeWhatsappClicks($range);

        return [
            'title' => 'Dashboard',
            'isMaster' => $isMaster,

            // Post stats
            'draftCount' => (clone $postQuery)->where('status', PostStatus::DRAFT)->count(),
            'publishedCount' => (clone $postQuery)->where('status', PostStatus::PUBLISHED)->count(),
            'totalCount' => (clone $postQuery)->count(),
            'recentPosts' => (clone $postQuery)->latest()->take(5)->get(),
            'postsThisMonth' => (clone $postQuery)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'totalViews' => $totalPostViews,
            'mostViewedPost' => $mostViewedPost,
            'postsHistoricalViewsJson' => json_encode($postViewsByDay),
            'postViewSummary' => $postViewSummary,

            // Website stats
            'webVisitorStatsJson' => json_encode($websiteVisitorStats),
            'websiteVisitorSummary' => $websiteVisitorSummary,

            'whatsappClickStatsJson' => json_encode($whatsappClickStats),
            'whatsappClickSummary' => $whatsappClickSummary,
        ];
    }

    /**
     * Calculate the total number of views across all related posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $postQuery The query builder instance for filtered posts.
     * @param bool $isMaster Whether the user is a master (admin) with access to all posts.
     * @return int Total number of views across the filtered posts.
     *
     * Used for post view statistics.
     */
    private function calculateTotalPostViews($postQuery, bool $isMaster): int
    {
        $postIds = (clone $postQuery)->pluck('id');
        return PostViewStatistic::whereIn('post_id', $postIds)->sum('views');
    }

    /**
     * Retrieve the most viewed post based on total view count.
     *
     * @param \Illuminate\Database\Eloquent\Builder $postQuery The query builder for posts.
     * @param bool $isMaster Whether the user is a master (admin).
     * @return \App\Models\Post|null The most viewed post, or null if none exists.
     *
     * Used for identifying the top-performing post.
     */
    private function getTopViewedPost($postQuery, bool $isMaster): ?Post
    {
        $postIds = (clone $postQuery)->pluck('id');

        $sub = DB::table('post_view_statistics')
            ->selectRaw('post_id, SUM(views) AS total_views')
            ->groupBy('post_id');

        return Post::select('posts.*', 'agg.total_views')
            ->joinSub($sub, 'agg', 'agg.post_id', '=', 'posts.id')
            ->whereIn('posts.id', $postIds)
            ->orderByDesc('agg.total_views')
            ->first();
    }

    /**
     * Generate historical view data for posts over a given date range.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user The currently authenticated user.
     * @param bool $isMaster Whether the user is a master (admin).
     * @param string $range The time range string (e.g., '7d', '30d', '2m').
     * @return array List of data points with formatted date (x) and view count (y).
     *
     * Used to display historical post views in chart format.
     */
    private function getPostViewHistory(Authenticatable $user, bool $isMaster, string $range = '7d'): array
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

        $rawViews = $query->groupBy('date')->orderBy('date')->get();
        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);

        return $dateRange->map(function ($date) use ($rawViews) {
            $label = $date->translatedFormat('d M Y');
            $match = $rawViews->first(fn($item) => Carbon::parse($item->date)->format('Y-m-d') === $date->format('Y-m-d'));

            return [
                'x' => $label,
                'y' => $match ? (int) $match->total_views : 0,
            ];
        })->all();
    }

    /**
     * Generate a summary of post view statistics including total, average, and peak day.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user The authenticated user.
     * @param bool $isMaster Whether the user is a master (admin).
     * @param string $range Time range string like '7d', '30d', etc.
     * @return array Summary including total views, average per day, and peak view day.
     *
     * Useful for showing high-level metrics about post performance.
     */
    private function summarizePostViews(Authenticatable $user, bool $isMaster, string $range = '7d'): array
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
        $peakDayLabel = $peakDay ? Carbon::parse($peakDay)->translatedFormat('l, d M Y') : '-';

        return [
            'totalViews' => $totalViews,
            'avgViews' => $avgViews,
            'peakDay' => $peakDayLabel,
        ];
    }

    /**
     * Generate historical website visitor data for a given date range.
     *
     * @param string $range The time range string (default is '7d').
     * @return array Array of daily visitor data points with date (x) and total visitors (y).
     *
     * Used to build the chart of website visitor trends.
     */
    private function getWebsiteVisitorHistory(string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        $rawData = VisitorStatistic::where('date', '>=', $fromDate->toDateString())
            ->orderBy('date')
            ->get(['date', 'visitors']);

        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);

        return $dateRange->map(function ($date) use ($rawData) {
            $match = $rawData->first(function ($item) use ($date) {
                return $item->date === $date->format('Y-m-d');
            });

            return [
                'x' => $date->translatedFormat('d M Y'), // e.g., "24 Jun"
                'y' => $match ? $match->visitors : 0,
            ];
        })->all();
    }

    /**
     * Ringkasan statistik pengunjung web: total, rata-rata harian, dan hari puncak.
     *
     * @param string $range  Contoh '7d', '30d', dst.
     * @return array ['totalVisitors' => 123, 'avgVisitors' => 18, 'peakDay' => 'Senin, 23 Jun 2025']
     */
    private function summarizeWebVisitors(string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        // agregasi seluruh data (tidak lagi difilter per user)
        $data = VisitorStatistic::select(
            'date',
            DB::raw('SUM(visitors) as total_visitors')
        )
            ->where('date', '>=', $fromDate->toDateString())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalVisitors = $data->sum('total_visitors');

        // hitung rata-rata harian berdasarkan rentang tanggal benar-benar penuh
        $dateRange  = $this->generateDateRange($fromDate, now(), $intervalType);
        $days       = $dateRange->count();
        $avgVisitors= $days > 0 ? round($totalVisitors / $days) : 0;

        $peakDay    = $data->sortByDesc('total_visitors')->first()?->date;
        $peakLabel  = $peakDay
            ? Carbon::parse($peakDay)->translatedFormat('l, d M Y')
            : '-';

        return [
            'totalVisitors' => $totalVisitors,
            'avgVisitors'   => $avgVisitors,
            'peakDay'       => $peakLabel,
        ];
    }

    /**
     * Retrieve historical WhatsApp click data per day for trend graph.
     *
     * @param string $range Time range ('7d', '30d', etc.)
     * @param int|null $buttonId (optional) if you want data per button
     * @return array Format: [['x' => '24 Jun 2025', 'y' => 17], ...]
     */
    private function getWhatsappClickHistory(string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        $rawData = WhatsappClickStatistic::where('date', '>=', $fromDate->toDateString())
            ->orderBy('date')
            ->get(['date', 'clicks']);

        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);

        return $dateRange->map(function ($date) use ($rawData) {
            $match = $rawData->first(fn ($item) => $item->date === $date->format('Y-m-d'));

            return [
                'x' => $date->translatedFormat('d M Y'),
                'y' => $match ? $match->clicks : 0,
            ];
        })->all();
    }

    /**
     * Generate a summary of WhatsApp clicks: total, daily average, and peak day.
     *
     * @param string $range Time range ('7d', '30d', etc.)
     * @param int|null $buttonId (optional) if you want data per button
     * @return array ['totalClicks' => 120, 'avgClicks' => 17, 'peakDay' => 'Monday, 23 Jun 2025']
     */
    private function summarizeWhatsappClicks(string $range = '7d'): array
    {
        [$fromDate, $intervalType] = $this->resolveDateRange($range);

        $query = WhatsappClickStatistic::select(
            'date',
            DB::raw('SUM(clicks) as total_clicks')
        )->where('date', '>=', $fromDate->toDateString());

        $data = $query->groupBy('date')->orderBy('date')->get();

        $totalClicks = $data->sum('total_clicks');

        $dateRange = $this->generateDateRange($fromDate, now(), $intervalType);
        $days = $dateRange->count();
        $avgClicks = $days > 0 ? round($totalClicks / $days) : 0;

        $peakDay = $data->sortByDesc('total_clicks')->first()?->date;
        $peakLabel = $peakDay
            ? Carbon::parse($peakDay)->translatedFormat('l, d M Y')
            : '-';

        return [
            'totalClicks' => $totalClicks,
            'avgClicks'   => $avgClicks,
            'peakDay'     => $peakLabel,
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
