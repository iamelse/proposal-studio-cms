@extends('layouts.frontend.post')

@section('content')
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

    <!-- Post Section -->
    <section id="post" class="pt-28 pb-16 bg-white transition-colors">
        <div class="mx-auto max-w-[1030px] px-4 sm:px-8 xl:px-0">

            <!-- Title & Excerpt -->
            <div class="mx-auto max-w-[770px] text-center">
                <h1 class="mb-5 text-2xl font-bold text-gray-800 sm:text-3xl md:text-4xl">
                    {{ $post->title }}
                </h1>
                <p class="mb-4 text-base text-gray-600">
                    {{ $post->excerpt }}
                </p>

                <!-- Author Info -->
                <div class="mt-6 flex flex-col justify-center gap-3 sm:flex-row sm:items-center">
                    <div class="flex h-10 w-10 overflow-hidden rounded-full">
                        <img
                            src="{{ getAuthorPostImagePath($post->user) }}"
                            alt="{{ $post->user->name }}"
                            width="40"
                            height="40"
                            loading="lazy"
                        />
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h4 class="text-sm font-medium text-gray-700">
                                {{ $post->user->name }}
                            </h4>
                            <i class="bx bxs-circle text-gray-700 text-[6px] mx-3"></i>
                            <div class="inline-flex items-center gap-2 text-gray-700">
                                <i class="bx bx-calendar text-sm"></i>
                                <p class="text-sm font-medium">{{ $post->formatted_published_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="w-full max-w-[1010px] mx-auto">
                <img
                    src="{{ getPostCoverImagePath($post) }}"
                    alt="Post cover image"
                    loading="lazy"
                    width="1030"
                    height="613"
                    class="my-10 w-full overflow-hidden rounded-[20px]"
                    style="color: transparent;"
                />
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
