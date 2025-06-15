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
                        {{ $dashboard['isMaster'] ? 'You have full access to all posts.' : 'These are your personal post stats.' }}
                    </p>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
                <!-- Draft Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-blue-100 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-blue-700 dark:text-blue-300">Draft Posts</h2>
                        <i class='bx bx-pencil text-2xl text-blue-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-blue-800 dark:text-blue-200">{{ $dashboard['draftCount'] }}</p>
                </div>

                <!-- Published Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-green-100 bg-green-50 dark:border-green-800 dark:bg-green-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-green-700 dark:text-green-300">Published Posts</h2>
                        <i class='bx bx-check-circle text-2xl text-green-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-green-800 dark:text-green-200">{{ $dashboard['publishedCount'] }}</p>
                </div>

                <!-- Total Posts -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-purple-100 bg-purple-50 dark:border-purple-800 dark:bg-purple-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-purple-700 dark:text-purple-300">Total Posts</h2>
                        <i class='bx bx-layer text-2xl text-purple-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-purple-800 dark:text-purple-200">{{ $dashboard['totalCount'] }}</p>
                </div>

                <!-- Posts This Month -->
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-yellow-100 bg-yellow-50 dark:border-yellow-800 dark:bg-yellow-900/10">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-yellow-700 dark:text-yellow-300">Posts This Month</h2>
                        <i class='bx bx-calendar text-2xl text-yellow-500'></i>
                    </div>
                    <p class="text-4xl font-bold text-yellow-800 dark:text-yellow-200">{{ $dashboard['postsThisMonth'] }}</p>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="gap-6 px-6">
                <!-- Draft Posts -->
                <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                                    <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                                    <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">{{ number_format($dashboard['viewSummary']['totalViews']) }}</h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total views (last {{ $range ?? '7d' }})</p>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2">
                        <dl class="flex items-center">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Avg. daily views:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">{{ number_format($dashboard['viewSummary']['avgViews']) }}</dd>
                        </dl>
                        <dl class="flex items-center justify-end">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Peak day:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">{{ $dashboard['viewSummary']['peakDay'] }}</dd>
                        </dl>
                    </div>

                    <div id="column-chart"></div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="px-6">
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="px-6 py-4 flex items-center justify-between border-b border-gray-100 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Recent Posts</h2>
                        <a href="{{ route('fe.post.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                    </div>

                    @if ($dashboard['recentPosts']->count())
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach ($dashboard['recentPosts'] as $post)
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

@section('bottom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <script>
        const rawData = {!! $dashboard['postsHistoricalViewsJson'] !!};

        const todayLabel = new Date().toLocaleString('en-US', { weekday: 'short' }); // "Mon", "Tue", ...

        const dynamicColors = rawData.map(item =>
            item.x === 'Today' ? '#FDBA8C' : '#1A56DB'
        );

        const options = {
            colors: dynamicColors,
            series: [
                {
                    name: "Total Views",
                    data: rawData.map(item => item.y)
                }
            ],
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                    borderRadiusApplication: "end",
                    borderRadius: 8,
                    distributed: true // <- Ini penting agar warna per bar bisa beda!
                },
            },
            xaxis: {
                categories: rawData.map(item => item.x),
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: { left: 2, right: 2, top: -14 },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            yaxis: {
                show: true,
                labels: {
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: "text-xs text-gray-500 dark:text-gray-400"
                    },
                    formatter: function (value) {
                        return value >= 1000 ? (value / 1000).toFixed(1).replace(/\.0$/, '') + 'K' : value;
                    }
                }
            },
            fill: {
                opacity: 1,
            },
        };

        if (document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("column-chart"), options);
            chart.render();
        }
    </script>
@endsection
