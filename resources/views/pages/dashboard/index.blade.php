@extends('layouts.app')

@section('content')
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6 space-y-10">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ getGreeting() }}, {{ getFirstName(Auth::user()->name) }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $isMaster ? 'You have full access to all posts.' : 'These are your personal post stats.' }}
                    </p>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6">
                <!-- Draft Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-blue-100 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-blue-700 dark:text-blue-300">Draft Posts</h2>
                        <i class='bx bx-pencil text-2xl text-blue-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-blue-800 dark:text-blue-200">{{ $draftCount }}</p>
                </div>

                <!-- Published Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-green-100 bg-green-50 dark:border-green-800 dark:bg-green-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-green-700 dark:text-green-300">Published Posts</h2>
                        <i class='bx bx-check-circle text-2xl text-green-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-green-800 dark:text-green-200">{{ $publishedCount }}</p>
                </div>

                <!-- Total Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-purple-100 bg-purple-50 dark:border-purple-800 dark:bg-purple-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-purple-700 dark:text-purple-300">Total Posts</h2>
                        <i class='bx bx-layer text-2xl text-purple-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-purple-800 dark:text-purple-200">{{ $totalCount }}</p>
                </div>
            </div>

            <!-- Insight Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6">
                <!-- Posts This Month -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-yellow-100 bg-yellow-50 dark:border-yellow-800 dark:bg-yellow-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-yellow-700 dark:text-yellow-300">Posts This Month</h2>
                        <i class='bx bx-calendar text-2xl text-yellow-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-yellow-800 dark:text-yellow-200">{{ $postsThisMonth }}</p>
                </div>

                <!-- Total Views -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-cyan-100 bg-cyan-50 dark:border-cyan-800 dark:bg-cyan-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-cyan-700 dark:text-cyan-300">Total Views</h2>
                        <i class='bx bx-show text-2xl text-cyan-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-cyan-800 dark:text-cyan-200">{{ number_format($totalViews) }}</p>
                </div>

                <!-- Top Viewed Post -->
                <div class="rounded-2xl px-6 pb-6 pt-4 border border-pink-100 bg-pink-50 dark:border-pink-800 dark:bg-pink-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-pink-700 dark:text-pink-300">Top Viewed Post</h2>
                        <i class='bx bx-star text-2xl text-pink-500'></i>
                    </div>
                    @if ($mostViewedPost)
                        <p class="text-base font-semibold text-pink-800 dark:text-pink-200 truncate">{{ $mostViewedPost->title }}</p>
                        <p class="text-sm text-pink-600 dark:text-pink-400">{{ number_format($mostViewedPost->views) }} views</p>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No data</p>
                    @endif
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="px-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Recent Posts</h2>
                        <a href="{{ route('fe.post.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                    </div>

                    @if ($recentPosts->count())
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($recentPosts as $post)
                                <li class="px-6 py-4 flex justify-between items-center">
                                    <span class="text-gray-800 dark:text-gray-300">{{ $post->title }}</span>
                                    <span class="text-sm px-2 py-1 rounded-full
                                    {{ $post->status === 'published'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="px-6 py-4 text-gray-500 dark:text-gray-400">No recent posts found.</p>
                    @endif
                </div>
            </div>

        </div>
    </main>
@endsection
