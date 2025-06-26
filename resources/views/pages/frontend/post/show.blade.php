@extends('layouts.frontend.post')

@push('meta')
    <!-- Meta Description & Keywords -->
    <meta name="description" content="{{ $post->seo_description ?? Str::limit(strip_tags($post->excerpt), 155) }}">
    <meta name="keywords" content="{{ $post->seo_keywords ?? '' }}">
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->seo_title ?? $post->title }}" />
    <meta property="og:description" content="{{ $post->seo_description ?? Str::limit(strip_tags($post->excerpt), 155) }}" />
    <meta property="og:image" content="{{ getPostCoverImagePath($post) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $post->seo_title ?? $post->title }}" />
    <meta name="twitter:description" content="{{ $post->seo_description ?? Str::limit(strip_tags($post->excerpt), 155) }}" />
    <meta name="twitter:image" content="{{ getPostCoverImagePath($post) }}" />
    {{-- Optional: Add Twitter handle --}}
    {{-- <meta name="twitter:site" content="@YourTwitterHandle" /> --}}
@endpush
@push('scripts')
    <!-- Optional: Structured data for search engines -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "{{ $post->seo_title ?? $post->title }}",
            "description": "{{ $post->seo_description ?? Str::limit(strip_tags($post->excerpt), 155) }}",
            "image": "{{ getPostCoverImagePath($post) }}",
            "author": {
                "@type": "Person",
                "name": "{{ $post->user->name }}"
            },
            "datePublished": "{{ $post->published_at }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ url()->current() }}"
            }
        }
    </script>
@endpush
@section('content')
    <!-- Post Section -->
    <section id="post" class="pt-28 pb-16 bg-white transition-colors">
        <div class="mx-auto max-w-[1030px] px-4 sm:px-8 xl:px-0">

            <!-- Title & Excerpt -->
            <div class="mx-auto max-w-[770px] text-center md:text-center">
                <h1 class="mb-5 text-2xl font-bold text-gray-800 sm:text-3xl md:text-4xl">
                    {{ $post->title }}
                </h1>
                <p class="mb-4 text-base text-gray-600">
                    {{ $post->excerpt }}
                </p>

                <!-- Author Info -->
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-sm text-gray-700">
                    <!-- Avatar -->
                    <img
                        src="{{ getAuthorPostImagePath($post->user) }}"
                        alt="{{ $post->created_by_name }}"
                        class="h-9 w-9 md:h-10 md:w-10 rounded-full object-cover"
                        width="40"
                        height="40"
                        loading="lazy"
                    />

                    <!-- Name -->
                    <span class="font-medium">
                        {{ $post->created_by_name }}
                    </span>

                    <!-- Dot Separator -->
                    <span class="text-3xl">•</span>

                    <!-- Date -->
                    <div class="flex items-center gap-1">
                        <i class="bx bx-calendar text-base"></i>
                        <time class="font-medium">{{ $post->formatted_published_at }}</time>
                    </div>
                </div>

            </div>

            <!-- Cover Image -->
            <div class="w-full max-w-[1010px] mx-auto">
                <div class="my-10 aspect-[16/9] overflow-hidden rounded-[20px]">
                    <img
                        src="{{ getPostCoverImagePath($post) }}"
                        alt="{{ basename($post->cover) }}"
                        loading="lazy"
                        class="w-full h-full object-cover"
                        style="color: transparent;"
                    />
                </div>
            </div>

            <!-- Body -->
            <div class="mx-auto max-w-[770px]">
                <p class="mb-4 text-base text-gray-600">
                    {!! $post->body !!}
                </p>
            </div>
        </div>
    </section>
@endsection
