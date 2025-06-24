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
                @php
                    $rangeLabels = ['7d' => 'Last 7 days', '30d' => 'Last 30 days', '90d' => 'Last 90 days'];
                    $selectedRange = $range ?? request('range', '7d');
                @endphp

                <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                    <!-- Post View Summary Header -->
                    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                <!-- Boxicon icon -->
                                <i class='bx bx-bar-chart-alt-2 text-2xl text-gray-500 dark:text-gray-400'></i>
                            </div>
                            <div>
                                <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">
                                    {{ number_format($dashboard['postViewSummary']['totalViews']) }}
                                </h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    Total post views ({{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }})
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Post View Summary Grid -->
                    <div class="grid grid-cols-2">
                        <dl class="flex items-center">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Avg. daily views:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">
                                {{ number_format($dashboard['postViewSummary']['avgViews']) }}
                            </dd>
                        </dl>
                        <dl class="flex items-center justify-end">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Peak day:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">
                                {{ $dashboard['postViewSummary']['peakDay'] }}
                            </dd>
                        </dl>
                    </div>

                    <!-- Post View Chart -->
                    <div id="post-view-chart"></div>

                    <!-- Filter Dropdown -->
                    <div class="grid grid-cols-1 items-center border-t border-gray-200 dark:border-gray-700 justify-between">
                        <div class="flex justify-between items-center pt-5">
                            <!-- Range Filter Button -->
                            <button
                                id="dropdownDefaultButton"
                                data-dropdown-toggle="lastDaysdropdown"
                                data-dropdown-placement="bottom"
                                class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                                type="button">
                                {{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }}
                                <svg class="w-2.5 m-2.5 ms-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                                    @foreach($rangeLabels as $key => $label)
                                        <li>
                                            <a href="{{ request()->fullUrlWithQuery(['range' => $key]) }}"
                                               class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ $selectedRange === $key ? 'font-semibold text-gray-900 dark:text-white' : '' }}">
                                                {{ $label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!--
                            <a
                                href="#"
                                class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                                Leads Report
                                <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                            </a>
                            -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Website Visitor Summary Card -->
            <div class="gap-6 px-6">
                <div class="w-full mt-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                    <!-- Header -->
                    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                <!-- Boxicon -->
                                <i class='bx bx-user text-2xl text-gray-500 dark:text-gray-400'></i>
                            </div>
                            <div>
                                <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">
                                    {{ number_format($dashboard['websiteVisitorSummary']['totalVisitors']) }}
                                </h5>
                                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    Website visitors ({{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }})
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Grid Summary -->
                    <div class="grid grid-cols-2">
                        <dl class="flex items-center">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Avg. daily visitors:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">
                                {{ number_format($dashboard['websiteVisitorSummary']['avgVisitors']) }}
                            </dd>
                        </dl>
                        <dl class="flex items-center justify-end">
                            <dt class="text-gray-500 dark:text-gray-400 text-sm font-normal me-1">Peak day:</dt>
                            <dd class="text-gray-900 text-sm dark:text-white font-semibold">
                                {{ $dashboard['websiteVisitorSummary']['peakDay'] }}
                            </dd>
                        </dl>
                    </div>

                    <!-- Chart -->
                    <div id="visitor-chart" class="pt-4"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <script>
        function createBarChart({ elementId, chartData, todayColor, defaultColor, seriesName }) {
            const colors = chartData.map(item => item.x === 'Today' ? todayColor : defaultColor);

            const options = {
                colors: colors,
                series: [
                    {
                        name: seriesName,
                        data: chartData.map(item => item.y)
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
                        distributed: true
                    },
                },
                xaxis: {
                    categories: chartData.map(item => item.x),
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
                            return value >= 1000
                                ? (value / 1000).toFixed(1).replace(/\.0$/, '') + 'K'
                                : value;
                        }
                    }
                },
                fill: {
                    opacity: 1,
                },
            };

            const chartElement = document.getElementById(elementId);
            if (chartElement && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }

        const chartConfigs = [
            {
                elementId: 'post-view-chart',
                data: {!! $dashboard['postsHistoricalViewsJson'] !!},
                colors: { today: '#FDBA8C', other: '#1A56DB' },
                seriesName: 'Total Views',
            },
            {
                elementId: 'visitor-chart',
                data: {!! $dashboard['webVisitorStatsJson'] !!},
                colors: { today: '#F59E0B', other: '#10B981' },
                seriesName: 'Visitors',
            }
        ];

        chartConfigs.forEach(config => {
            createBarChart({
                elementId: config.elementId,
                chartData: config.data,
                todayColor: config.colors.today,
                defaultColor: config.colors.other,
                seriesName: config.seriesName
            });
        });
    </script>
@endsection
