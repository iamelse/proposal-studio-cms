@extends('layouts.app')

@section('content')
    @php
        use App\Enums\RoleEnum;

        $rangeLabels   = ['7d' => 'Last 7 days', '30d' => 'Last 30 days', '90d' => 'Last 90 days'];
        $selectedRange = $range ?? request('range', '7d');
        $rangeDays     = (int) preg_replace('/\D/', '', $selectedRange);   // 7, 30, 90 …
        $isMaster      = auth()->user()->roles->first()?->name === RoleEnum::MASTER->value;
    @endphp
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6 space-y-10">

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ getGreeting() }}, {{ getFirstName(Auth::user()->name) }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $dashboard['isMaster'] ? 'Dashboard shows complete data across the system.' : 'Dashboard shows stats based on your own activity.' }}
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

            <div class="flex justify-end gap-2 px-6">
                <!-- Reset Filter Button -->
                <a href="{{ route('be.dashboard.index') }}"
                   class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-gray-400 bg-gray-100 text-gray-700 font-medium transition-all hover:bg-gray-200 hover:border-gray-500 focus:ring focus:ring-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700">
                    <i class="bx bx-reset text-lg"></i>
                    Reset Filter
                </a>

                <!-- Filter Modal -->
                <div x-data="{ open: false, selectedField: '{{ request()->query('filter') ? array_key_first(request('filter')) : '' }}' }">
                    <!-- Filter Button -->
                    <button @click.prevent="open = true"
                            class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-purple-500 bg-purple-600 text-white font-medium transition-all hover:bg-purple-700 hover:border-purple-600 focus:ring focus:ring-purple-300 dark:bg-purple-700 dark:border-purple-600 dark:hover:bg-purple-800">
                        <i class="bx bx-filter text-lg"></i>
                        Filter
                    </button>

                    <!-- Modal -->
                    <div x-cloak x-show="open" @keydown.escape.window="open = false"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                        <div @click.away="open = false"
                             class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-1/2">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Filter Options</h2>

                            <!-- Form -->
                            <form method="GET" action="{{ route('be.dashboard.index') }}">
                                <!-- Range Input (e.g., 7d, 90d, etc.) -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Range (Days Ago) — e.g., 7d, 30d, 60d, 90d
                                    </label>

                                    <input type="text" name="range"
                                           value="{{ old('range', request('range', '')) }}"
                                           pattern="^\d+d$"
                                           placeholder="7d"
                                           class="w-full mt-1 px-3 py-2 rounded-lg
                                                  bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300
                                                  focus:ring focus:ring-blue-500 focus:outline-none
                                                  border {{ $errors->has('range') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-700' }}"
                                    >

                                    @if ($errors->has('range'))
                                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                            *{{ $errors->first('range') }}
                                        </p>
                                    @else
                                        <span class="text-xs text-gray-600 dark:text-gray-400">
                                            Use format like <code>7d</code>, <code>90d</code>, etc.
                                        </span>
                                    @endif
                                </div>

                                <!-- Buttons -->
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" @click="open = false"
                                            class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Apply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 px-6 mt-6">

                {{-- === CARD 1: Website Visitors (MASTER only) === --}}
                @if($isMaster)
                    <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                    <i class='bx bx-user text-2xl text-gray-500 dark:text-gray-400'></i>
                                </div>
                                <div>
                                    <h5 class="text-2xl font-bold text-gray-900 dark:text-white leading-none pb-1">
                                        {{ number_format($dashboard['websiteVisitorSummary']['totalVisitors']) }}
                                    </h5>
                                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        Website visitors ({{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }})
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <dl class="flex items-center">
                                <dt class="text-gray-500 dark:text-gray-400 me-1">Avg. daily visitors:</dt>
                                <dd class="text-gray-900 dark:text-white font-semibold">
                                    {{ number_format($dashboard['websiteVisitorSummary']['avgVisitors']) }}
                                </dd>
                            </dl>
                            <dl class="flex items-center justify-end">
                                <dt class="text-gray-500 dark:text-gray-400 me-1">Peak day:</dt>
                                <dd class="text-gray-900 dark:text-white font-semibold">
                                    {{ $dashboard['websiteVisitorSummary']['peakDay'] }}
                                </dd>
                            </dl>
                        </div>
                        <div id="visitor-chart" class="pt-4"></div>
                    </div>
                @endif

                {{-- === CARD 2 & 3 === --}}
                @if($isMaster)
                    <div class="grid grid-cols-1 {{ $rangeDays < 30 ? 'md:grid-cols-2' : '' }} gap-6">
                        @endif

                        {{-- === Post View Card (selalu tampil) === --}}
                        <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                        <i class='bx bx-bar-chart-alt-2 text-2xl text-gray-500 dark:text-gray-400'></i>
                                    </div>
                                    <div>
                                        <h5 class="text-2xl font-bold text-gray-900 dark:text-white leading-none pb-1">
                                            {{ number_format($dashboard['postViewSummary']['totalViews']) }}
                                        </h5>
                                        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            Total post views ({{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }})
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 text-sm">
                                <dl class="flex items-center">
                                    <dt class="text-gray-500 dark:text-gray-400 me-1">Avg. daily views:</dt>
                                    <dd class="text-gray-900 dark:text-white font-semibold">
                                        {{ number_format($dashboard['postViewSummary']['avgViews']) }}
                                    </dd>
                                </dl>
                                <dl class="flex items-center justify-end">
                                    <dt class="text-gray-500 dark:text-gray-400 me-1">Peak day:</dt>
                                    <dd class="text-gray-900 dark:text-white font-semibold">
                                        {{ $dashboard['postViewSummary']['peakDay'] }}
                                    </dd>
                                </dl>
                            </div>
                            <div id="post-view-chart" class="pt-4"></div>
                        </div>

                        {{-- === WhatsApp Card (MASTER only) === --}}
                        @if($isMaster)
                            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                                <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                                            <i class='bx bxl-whatsapp text-2xl text-gray-500 dark:text-gray-400'></i>
                                        </div>
                                        <div>
                                            <h5 class="text-2xl font-bold text-gray-900 dark:text-white leading-none pb-1">
                                                {{ number_format($dashboard['whatsappClickSummary']['totalClicks']) }}
                                            </h5>
                                            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                                WhatsApp clicks ({{ $rangeLabels[$selectedRange] ?? 'Last 7 days' }})
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 text-sm">
                                    <dl class="flex items-center">
                                        <dt class="text-gray-500 dark:text-gray-400 me-1">Avg. daily clicks:</dt>
                                        <dd class="text-gray-900 dark:text-white font-semibold">
                                            {{ number_format($dashboard['whatsappClickSummary']['avgClicks']) }}
                                        </dd>
                                    </dl>
                                    <dl class="flex items-center justify-end">
                                        <dt class="text-gray-500 dark:text-gray-400 me-1">Peak day:</dt>
                                        <dd class="text-gray-900 dark:text-white font-semibold">
                                            {{ $dashboard['whatsappClickSummary']['peakDay'] }}
                                        </dd>
                                    </dl>
                                </div>
                                <div id="wa-click-chart" class="pt-4"></div>
                            </div>
                    </div>
                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->has('range'))
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "{{ $errors->first('range') }}",
                    showConfirmButton: false,
                    timer: 6000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 shadow-lg',
                        title: 'font-normal text-base text-gray-800 dark:text-gray-200'
                    }
                });
            @endif
        });
    </script>
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
            },
            {
                elementId: 'wa-click-chart',
                data: {!! $dashboard['whatsappClickStatsJson'] !!}, // array [['x' => '24 Jun 2025', 'y' => 17], ...]
                colors: { today: '#EF4444', other: '#3B82F6' },     // merah utk “Today”, biru utk lainnya
                seriesName: 'WhatsApp Clicks',
            },
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
