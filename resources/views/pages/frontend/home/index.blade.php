@extends('layouts.frontend.app')

@section('hero')
    <!-- Hero Section -->
    @php
        $content = json_decode($hero->content);
    @endphp

    <section id="home" class="mt-24 md:mt-[170px] max-w-full mx-4 flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('assets/images/bg.png') }}');">
        <div class="text-center flex flex-col items-center mt-2 w-full">
            <header class="px-4 py-2 rounded-full md:px-4 md:py-3 border-2 border-brandSecondary bg-[#FAE8DF] w-fit">
                <p class="text-xs font-medium md:text-sm text-brandSecondary">
                    {{ $content->subtitle ?? '' }}
                </p>
            </header>

            <div class="items-center mt-2 max-w-5xl">
                <h1 class="text-3xl md:text-5xl lg:text-7xl font-bold text-[#1f2328]">
                    {!! $content->title ?? '' !!}
                </h1>
            </div>

            <div class="mt-[14px] max-w-4xl">
                <p class="text-base md:text-xl font-medium text-brandBase">
                    {!! $content->description ?? '' !!}
                </p>
            </div>

            <div class="mt-10">
                <a href="https://wa.me/{{ $settings['whatsapp_number_with_country_code'] }}?text=Hallo%20Kak%2C%20saya%20ingin%20tanya%20terkait%20proposal%2C%20apakah%20bisa%20dibantu%3F" target="_blank" rel="noopener noreferrer">
                    <button class="bg-[#05408C] hover:bg-[#05408C]/80 focus:ring-4 focus:ring-blue-300 ease-in duration-200 rounded-full flex py-4 px-6 md:py-5 md:px-8 gap-2 items-center" aria-label="Konsultasi Gratis melalui WhatsApp">
                        <i class='bx bxl-whatsapp text-white text-2xl'></i>
                        <span class="font-medium text-base md:text-lg text-white">Konsultasi Gratis</span>
                    </button>
                </a>
            </div>
        </div>
    </section>
@endsection

@section('features')
    <!-- Features Section -->
    <section class="bg-[#05408C]/70 mb-[100px] max-w-full rounded-[20px] mt-[60px] px-6 py-12 sm:px-10 md:px-16 lg:px-20 mx-5 lg:mx-20">
        <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-semibold text-center">
            Keunggulan Memilih Layanan Kami
        </h2>

        <!-- Mobile/Tablet Slider -->
        <div class="lg:hidden mt-14 overflow-hidden relative">
            <div id="feature-slider" class="flex transition-transform duration-500 ease-in-out w-full">
                @foreach ($whyUsList as $feature)
                    <article class="flex-shrink-0 w-full px-8 flex flex-col items-center text-center max-w-full">
                        <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center mx-auto">
                            <img src="{{ getWhyUsListImagePath($feature) }}" alt="{{ $feature->title }}">
                        </figure>
                        <h3 class="font-medium text-lg text-white mt-4">{{ $feature->title }}</h3>
                    </article>
                @endforeach
            </div>

            <!-- Slider Dots -->
            <div id="feature-dots" class="flex justify-center mt-6 space-x-2">
                @foreach (range(0, 5) as $i)
                    <button class="w-3 h-3 rounded-full bg-white opacity-50"></button>
                @endforeach
            </div>
        </div>

        <!-- Desktop Grid -->
        <div class="hidden lg:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 gap-x-6 mt-14 justify-items-center">
            @foreach ($whyUsList as $feature)
                <article class="flex flex-col items-center text-center max-w-[160px]">
                    <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                        <img src="{{ getWhyUsListImagePath($feature) }}" alt="{{ $feature->title }}">
                    </figure>
                    <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">
                        {{ $feature->title }}
                    </h3>
                </article>
            @endforeach
        </div>
    </section>
@endsection

@section('about')
    <!-- About Section -->
    @php
        $content = json_decode($about->content);
    @endphp
    <section id="about" class="flex flex-col items-center justify-between lg:flex-row mx-5 lg:mx-20 my-16 md:my-[100px]">
        <div class="max-w-xl">
            <h2 class="text-baseBlack text-2xl md:text-4xl tracking-tight mb-4 font-bold">
                {!! $content->title !!}
            </h2>
            <p class="mt-6 text-base md:text-lg text-baseBlack">
                {!! $content->description !!}
            </p>

            @php
                $stats = old('content.stats', $content->stats ?? []);
                $stats = array_pad($stats, 3, (object) ['title' => '', 'value' => '', 'suffix' => '']);
            @endphp

            <div class="flex flex-row gap-1 items-center justify-between lg:flex-row pt-6 flex-wrap">
                @foreach (array_slice($stats, 0, 3) as $index => $stat)
                    @if ($index > 0)
                        <div class="hidden md:block w-px h-10 bg-gray-300"></div>
                    @endif

                    <div class="text-center">
                        <h3 class="text-baseBlack font-semibold text-xl md:text-2xl lg:text-3xl">
                            {{ $stat->value ?? '' }}{{ $stat->suffix ?? '' }}
                        </h3>
                        <p class="text-baseBlack font-normal text-base md:text-xl">
                            {{ $stat->title ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
        <figure class="max-w-xl mt-5 lg:mt-0">
            <img class="object-cover w-full h-full rounded-lg" src="{{ getAboutUsImageSection($content) }}" alt="Foto Profil Proposal Studio">
        </figure>
    </section>
@endsection

@section('services')
    @php
        $content = json_decode($ourService->content);
    @endphp
    <section id="service" class="mx-5 my-14 md:mx-20 md:my-[100px]">
        <div class="lg:w-1/2 text-center mx-auto">
            <h1 class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
                {!! $content->title !!}
            </h1>
            <h2 class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
                {{ $content->subtitle }}
            </h2>
        </div>

        <div class="mt-8 md:mt-16 md:grid md:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <article class="py-6 px-2 flex flex-col items-center justify-center text-center">
                    <div class="mb-2">
                        <img src="{{ getServiceListImagePath($service) }}" alt="{{ $service->title }}" class="w-16 h-16 object-contain">
                    </div>
                    <h2 class="md:text-xl lg:text-2xl text-baseBlack font-semibold mt-2">
                        {{ $service->title }}
                    </h2>
                    <p class="font-normal md:text-sm lg:text-base text-baseBlack mt-3">
                        {{ $service->description }}
                    </p>
                </article>
            @endforeach
        </div>
    </section>
@endsection

@section('clients')
    @php
        $content = json_decode($proposal->content);
    @endphp
    <div id="proposal" class="mx-5 my-14 md:mx-10">
        <h2 class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
            {!! $content->title !!}
        </h2>
        <p class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
            {{ $content->subtitle }}
        </p>

        <!-- Carousel with Arrows Flex Wrapper -->
        <div class="mt-8 md:mt-16 flex items-center justify-center gap-5">
            <!-- Left Arrow -->
            <button id="client-prev" class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-left-arrow-alt text-lg'></i>
            </button>

            <!-- Carousel -->
            <div class="relative flex-1 overflow-hidden">
                <div id="clientCarousel" class="flex overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory px-0">
                    <!-- Spacer at start -->
                    <div class="hidden md:block flex-shrink-0 w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]"></div>

                    @foreach ($proposals as $proposal)
                        <div class="flex-shrink-0 w-[calc(100%-16px)] md:w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)] snap-start mx-2 border rounded-md">
                            <div class="bg-white rounded-md hover:shadow-lg transition-shadow duration-300 p-4 flex items-center justify-center">
                                <img src="{{ getProposalListImagePath($proposal) }}" alt="{{ $proposal->title }}" class="w-full h-full object-cover rounded-md" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Arrow -->
            <button id="client-next" class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </button>
        </div>
    </div>
@endsection

@section('events')
    @php
        $content = json_decode($event->content);
    @endphp
    <div id="event" class="mx-5 my-14 md:mx-10 bg-cover bg-center" style="background-image: url('https://raw.githubusercontent.com/vikifsyh/proposal-studio/main/public/bg2.png')">
        <h2 class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
            {!! $content->title !!}
        </h2>
        <p class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
            {{ $content->subtitle }}
        </p>

        <!-- Carousel with Arrows Flex Wrapper -->
        <div class="mt-8 md:mt-16 flex items-center justify-center gap-5">
            <!-- Left Arrow -->
            <button id="event-prev" class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-left-arrow-alt text-lg'></i>
            </button>

            <!-- Carousel -->
            <div class="relative flex-1 overflow-hidden">
                <div id="eventCarousel" class="flex overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory px-0">
                    <!-- Spacer at start -->
                    <div class="hidden md:block flex-shrink-0 w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]"></div>

                    @foreach ($events as $event)
                        <div class="flex-shrink-0 w-[calc(100%-16px)] md:w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)] snap-start mx-2 border rounded-md">
                            <div class="bg-white rounded-md hover:shadow-lg transition-shadow duration-300 p-4 flex flex-col items-start justify-start">
                                <img src="{{ getEventListImagePath($event) }}" alt="{{ $event->title }}" class="w-full h-full object-cover rounded-md" />
                                <h3 class="text-baseBlack text-center text-base md:text-xl mt-4 line-clamp-2 font-semibold">
                                    {{ $event->title }}
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Arrow -->
            <button id="event-next" class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </button>
        </div>
    </div>
@endsection

@section('reviews')
    @php
        $content = json_decode($review->content);
    @endphp
    @php
        function renderStars($rating): string {
            $stars = '';
            $rating = floatval($rating); // pastikan float
            for ($i = 1; $i <= 5; $i++) {
                if ($rating >= $i) {
                    $stars .= '<i class="bx bxs-star bx-sm text-yellow-400"></i>';
                } elseif ($rating >= $i - 0.5) {
                    $stars .= '<i class="bx bxs-star-half bx-sm text-yellow-400"></i>';
                } else {
                    $stars .= '<i class="bx bx-star bx-sm text-yellow-400"></i>';
                }
            }
            return $stars;
        }
    @endphp

    <div class="my-24 mx-5 md:mx-20">
        <div class="text-center">
            <h2 class="text-gray-900 text-2xl md:text-4xl font-bold">
                {!! $content->title !!}
            </h2>
        </div>

        <div class="relative overflow-hidden mt-8 md:mt-16">
            <!-- Fade effect sides -->
            <div class="absolute top-0 left-0 w-32 h-full z-10 bg-gradient-to-r from-white to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-32 h-full z-10 bg-gradient-to-l from-white to-transparent pointer-events-none"></div>

            <!-- Marquee track -->
            <div class="flex w-max gap-5 animate-marquee-fast">
                @foreach ($reviews as $review)
                    <figure class="w-[400px] h-[240px] rounded-[20px] px-8 py-7 border border-slate-200 bg-white flex-shrink-0">
                        <figcaption class="flex gap-5 items-center">
                            <div class="w-14 h-14 rounded-full overflow-hidden">
                                <img src="{{ $review->image }}" alt="Review oleh {{ $review->company_name }}" class="w-full h-full object-cover rounded-full">
                            </div>
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800">{{ $review->name }}</span>
                                <span class="text-sm text-slate-500">{{ $review->company_name }}</span>
                            </div>
                        </figcaption>
                        <blockquote>
                            <p class="text-gray-600 text-base mt-6 line-clamp-3 break-words">
                                {{ $review->comment }}
                            </p>
                            <div class="flex gap-1 mt-5">
                                {!! renderStars($review->rating) !!}
                            </div>
                        </blockquote>
                    </figure>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('faqs')
    @php
        $content = json_decode($faq->content);
    @endphp
    <div class="mx-5 my-14 md:mx-20 md:my-[100px] flex flex-col items-center justify-center">
        <h2 class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
            {!! $content->title !!}
        </h2>

        <div class="w-full max-w-6xl md:mt-10 mt-5">
            @foreach ($faqs as $faq)
                <div class="border-b border-gray-300 last:border-b-0">
                    <button
                        type="button"
                        aria-controls="faq-content-{{ $faq->id }}"
                        aria-expanded="false"
                        id="faq-toggle-{{ $faq->id }}"
                        class="w-full flex flex-1 items-center justify-between p-4 rounded-2xl transition-all hover:text-white hover:bg-brandPrimary text-start text-base md:text-xl font-medium text-baseBlack faq-toggle"
                        data-target="faq-content-{{ $faq->id }}"
                    >
                        {{ $faq->question }}
                        <i class="bx bx-chevron-down text-2xl transition-transform duration-200"></i>
                    </button>
                    <div
                        id="faq-content-{{ $faq->id }}"
                        class="hidden text-sm md:text-lg text-baseBlack font-normal mt-3 px-4 mb-4"
                        role="region"
                        aria-labelledby="faq-toggle-{{ $faq->id }}"
                    >
                        {{ $faq->answer }}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('cta')
    @php
        $content = json_decode($callToAction->content);
    @endphp
    <div class="md:mx-20 mx-5 mt-14 md:mt-[100px] md:mb-16 mb-8">
        <div class="bg-brandPrimary rounded-2xl md:rounded-[40px] p-8 md:p-16">
            <div class="lg:flex lg:items-center lg:justify-between lg:gap-20">
                <!-- Teks di kiri -->
                <div class="text-center lg:text-left">
                    <h1 class="text-2xl lg:text-4xl text-white font-semibold">
                        {!! $content->title !!}
                    </h1>
                </div>

                <!-- Tombol di kanan -->
                <div class="flex justify-center lg:justify-end mt-6 lg:mt-0">
                    <a href="https://wa.me/{{ $settings['whatsapp_number_with_country_code'] }}?text={{ urlencode('Hallo Kak, saya ingin tanya terkait proposal, apakah bisa dibantu?') }}">
                        <button
                            class="flex gap-2 items-center justify-center px-4 py-2 bg-brandPrimary border border-white rounded-full
                                   lg:px-8 lg:py-4 lg:gap-4
                                   hover:bg-brandPrimary/50 ease-in-out duration-200 focus:ring-4 focus:ring-blue-300 focus:text-white hover:text-white
                                   text-white whitespace-nowrap text-sm lg:text-xl"
                        >
                            Konsultasi Gratis
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
