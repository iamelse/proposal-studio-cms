@extends('layouts.frontend.posts')

@section('content')
    @push('meta')
        <title>{{ $title ?? 'Daftar Artikel - ' . env('APP_NAME') }}</title>
        <meta name="description" content="Baca kumpulan artikel terbaru seputar berbagai topik menarik yang dikurasi secara informatif dan inspiratif.">
        <meta name="keywords" content="artikel terbaru, blog, berita, informasi, edukasi, inspirasi">
        <link rel="canonical" href="{{ url()->current() }}" />

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $title ?? 'Daftar Artikel - ' . env('APP_NAME') }}" />
        <meta property="og:description" content="Jelajahi artikel-artikel pilihan kami yang menarik dan penuh informasi." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:image" content="{{ asset('assets/images/social-share.png') }}" />

        <!-- Twitter Cards -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'Daftar Artikel - ' . env('APP_NAME') }}">
        <meta name="twitter:description" content="Jelajahi artikel-artikel pilihan kami yang menarik dan penuh informasi.">
        <meta name="twitter:image" content="{{ asset('assets/images/social-share.png') }}">
    @endpush

    @push('meta')
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "CollectionPage",
              "name": "Daftar Artikel",
              "description": "Kumpulan artikel blog dengan topik menarik dan edukatif.",
              "url": "{{ url()->current() }}",
              "mainEntity": [
                        @foreach($posts as $post)
                            {
                              "@type": "BlogPosting",
                              "headline": "{{ $post->title }}",
                              "url": "{{ route('fe.post.show', $post->slug) }}",
                              "datePublished": "{{ $post->published_at }}",
                              "author": {
                                "@type": "Person",
                                "name": "{{ $post->user->name }}"
                              },
                              "image": "{{ getPostCoverImagePath($post) }}"
                            } @if(!$loop->last),@endif
                        @endforeach
                        ]
            }
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                AOS.init({
                    duration: 1000,
                    once: true,
                });
            });
        </script>
    @endpush

    <!-- Bagian Postingan -->
    <section id="post" class="py-16 lg:py-32 bg-white transition-colors">
        <div class="max-w-6xl mx-auto px-6">
            <h1 data-aos="fade-up" class="mt-10 lg:mt-0 text-3xl sm:text-4xl md:text-5xl font-bold leading-tight text-gray-900">
                Daftar Artikel
            </h1>
            <p class="mt-5 text-base sm:text-lg text-gray-600">
                Temukan koleksi artikel menarik yang telah dikurasi dengan cermat, mencakup berbagai topik untuk menginspirasi, mengedukasi, dan menghibur pembaca. Jelajahi sekarang!
            </p>

            <!-- Alpine.js Setup -->
            <div x-data="{ open: false }">
                <div class="flex flex-wrap items-end justify-end gap-4 mt-7">
                    <!-- Tombol Filter -->
                    <button @click="open = true"
                            class="w-1/3 md:w-1/6 lg:w-1/6 inline-flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-base font-semibold text-white transition-all duration-200 ease-in-out bg-[#05408C] hover:bg-[#04356F] focus:outline-none focus:ring-2 focus:ring-[#05408C]">
                        <i class='bx bx-filter text-lg'></i> Filter
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="open" x-transition.opacity x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                        <!-- Header Modal -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">Opsi Filter</h2>
                            <button @click="open = false" class="text-gray-500 hover:text-gray-700">
                                <i class='bx bx-x text-2xl'></i>
                            </button>
                        </div>

                        <!-- Form Filter -->
                        <form method="GET" action="{{ route('fe.post.index') }}">
                            <div class="space-y-4">
                                <!-- Input Pencarian -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cari</label>
                                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari..."
                                           class="w-full px-4 py-3 mt-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#05408C] focus:outline-none" />
                                </div>

                                <!-- Pilihan Kategori -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select name="category"
                                            class="w-full px-4 py-3 mt-2 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#05408C] focus:outline-none">
                                        <option value="">Semua Kategori</option>
                                        @foreach($postCategories as $category)
                                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Footer Modal -->
                            <div class="flex justify-end mt-5">
                                <button type="button" @click="open = false"
                                        class="px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                                <button type="submit"
                                        class="ml-3 px-6 py-2 text-white bg-[#05408C] rounded-lg hover:bg-[#04356F]">Terapkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kartu Postingan -->
            <div class="mt-10 flex flex-col lg:flex-row items-center gap-10">
                <div class="w-full">
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($posts as $post)
                            <article class="border border-gray-200 rounded-3xl p-2.5 bg-white flex flex-col"
                                 data-aos="zoom-in" data-aos-delay="{{ 200 + ($loop->index * 150) }}">
                                <img src="{{ getPostCoverImagePath($post) }}" alt="{{ $post->seo_title ?? $post->title }}"
                                     class="w-full rounded-2xl aspect-[16/9] object-cover">
                                <div class="flex flex-col flex-grow p-3">
                                    <h2 class="text-2xl py-2 font-semibold">
                                        <a href="{{ route('fe.post.show', $post->slug) }}"
                                           class="text-gray-900 hover:text-[#05408C] transition">
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    <p class="my-2 text-gray-500 flex-grow">
                                        {{ $post->excerpt }}
                                    </p>
                                    <div class="mt-4">
                                        <a href="{{ route('fe.post.show', $post->slug) }}"
                                           class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#05408C] px-6 py-3 text-base font-medium text-white shadow-xs duration-200 hover:bg-[#04356F] w-full sm:w-auto">
                                            Baca Selengkapnya
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-center col-span-3 text-gray-500">Tidak ada postingan yang ditemukan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Navigasi Halaman -->
            <div>
                <div class="flex items-end justify-center gap-2 py-4 sm:justify-normal md:justify-end">
                    <!-- Tombol Sebelumnya -->
                    @if ($posts->onFirstPage())
                        <button disabled
                                class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-400 cursor-not-allowed shadow-theme-xs sm:px-3.5 sm:py-2.5">
                            <span class="hidden sm:inline">Sebelumnya</span>
                            <span class="inline sm:hidden">←</span>
                        </button>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}"
                           class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 shadow-theme-xs sm:px-3.5 sm:py-2.5">
                            <span class="hidden sm:inline">Sebelumnya</span>
                            <span class="inline sm:hidden">←</span>
                        </a>
                    @endif

                    <!-- Nomor Halaman -->
                    <ul class="hidden items-center gap-0.5 sm:flex">
                        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                                <li><span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#05408C] text-sm font-medium text-white">{{ $page }}</span></li>
                            @elseif ($page >= $posts->currentPage() - 2 && $page <= $posts->currentPage() + 2)
                                <li><a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-gray-700 hover:bg-[#05408C] hover:text-white">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    </ul>

                    <!-- Halaman untuk perangkat kecil -->
                    <span class="block text-sm self-center font-medium text-gray-700 sm:hidden">
                        Halaman {{ $posts->currentPage() }} dari {{ $posts->lastPage() }}
                    </span>

                    <!-- Tombol Berikutnya -->
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}"
                           class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 shadow-theme-xs sm:px-3.5 sm:py-2.5">
                            <span class="hidden sm:inline">Berikutnya</span>
                            <span class="inline sm:hidden">→</span>
                        </a>
                    @else
                        <button disabled
                                class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-400 cursor-not-allowed shadow-theme-xs sm:px-3.5 sm:py-2.5">
                            <span class="hidden sm:inline">Berikutnya</span>
                            <span class="inline sm:hidden">→</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
