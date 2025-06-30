@extends('layouts.frontend.app')

@push('meta')
    <!-- Meta title -->
    <title>{{ $settings['home_title'] ?? env('APP_NAME') }}</title>

    <!-- Meta Description -->
    <meta name="description" content="{{ $settings['home_description'] }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Meta Keywords (opsional & jarang dipakai oleh Google) -->
    <meta name="keywords" content="jasa pembuatan proposal, konsultasi proposal, event proposal, jasa event, konsultan event">

    <!-- Open Graph (Facebook, LinkedIn, dll) -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $settings['home_title'] ?? env('APP_NAME') }}" />
    <meta property="og:description" content="Temukan solusi terbaik untuk kebutuhan proposal, event, atau jasa konsultasi Anda." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ getOgImageHomePath($settings) }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $settings['home_title'] ?? env('APP_NAME') }}" />
    <meta name="twitter:description" content="{{ $settings['home_description'] }}" />
    <meta name="twitter:image" content="{{ getOgImageHomePath($settings) }}" />
@endpush

@push('meta')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebPage",
          "name": "{{ env('APP_NAME') }}",
          "url": "{{ url('/') }}",
          "description": "Halaman resmi {{ env('APP_NAME') }} yang menampilkan layanan, klien, acara, testimoni, dan informasi lainnya.",
          "mainEntity": [
            {
              "@type": "Organization",
              "name": "{{ env('APP_NAME') }}",
              "url": "{{ url('/') }}",
              "logo": "{{ asset('path/to/logo.png') }}",
              "sameAs": [
                @foreach($socialMedia as $item)
                    "{{ $item->url }}"@if(!$loop->last),@endif
                @endforeach
                ]
              },
              {
                "@type": "Service",
                "name": "Layanan Kami",
                "description": "Berbagai layanan profesional dari {{ env('APP_NAME') }}",
              "provider": {
                "@type": "Organization",
                "name": "{{ env('APP_NAME') }}"
              }
            },
            {
              "@type": "AboutPage",
              "name": "Tentang Kami",
              "description": "Pelajari lebih lanjut tentang {{ env('APP_NAME') }} dan perjalanan kami."
            },
            {
              "@type": "ItemList",
              "name": "Klien Kami",
              "itemListElement": [
                @foreach($proposals as $item)
                    {
                      "@type": "ImageObject",
                      "contentUrl": "{{ getProposalListImagePath($item) }}",
                    "name": "{{ $item->title }}"
                  }@if(!$loop->last),@endif
                @endforeach
                ]
              },
              {
                "@type": "WebPageElement",
                "name": "Call To Action",
                "description": "Hubungi kami sekarang untuk memulai proyek Anda!"
              }
            ]
          }
    </script>

    {{-- Review(s) --}}
    @foreach ($reviews as $item)
        <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Review",
              "reviewRating": {
                "@type": "Rating",
                "ratingValue": "{{ $item->rating }}",
                "bestRating": "5"
              },
              "author": {
                "@type": "Person",
                "name": "{{ $item->name }}"
              },
              "itemReviewed": {
                "@type": "Organization",
                "name": "{{ env('APP_NAME') }}"
              },
              "reviewBody": "{{ addslashes($item->comment) }}"
            }
        </script>
    @endforeach

    {{-- FAQ --}}
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "FAQPage",
          "mainEntity": [
            @foreach ($faqs as $item)
                {
                  "@type": "Question",
                  "name": "{{ addslashes(strip_tags($item->question)) }}",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "{{ addslashes(strip_tags($item->answer)) }}"
                  }
                }@if(!$loop->last),@endif
            @endforeach
            ]
        }
    </script>
@endpush

{{-- =======================  HERO  ======================= --}}
@section('hero')
    <!-- Hero Section -->
    @php
        $content = json_decode($hero->content);
    @endphp

    <section id="home"
             class="mt-24 md:mt-[170px] max-w-full mx-4 flex items-center justify-center bg-cover bg-center"
             style="background-image:url('{{ asset('assets/images/bg.webp') }}');"
             role="region" aria-labelledby="hero-title">
        <div class="text-center flex flex-col items-center mt-2 w-full">
            <header class="px-4 py-2 rounded-full md:px-4 md:py-3 border-2 border-brandSecondary bg-[#FAE8DF] w-fit">
                <p class="text-xs font-medium md:text-sm text-brandSecondary">
                    {{ $content->subtitle ?? '' }}
                </p>
            </header>

            <div class="items-center mt-2 max-w-5xl">
                {{-- H1 TUNGGAL HALAMAN --}}
                <h1 id="hero-title"
                    class="text-3xl md:text-5xl lg:text-7xl font-bold text-[#1f2328] mb-6">
                    {!! $content->title ?? '' !!}
                </h1>
            </div>

            <div class="mt-[14px] max-w-4xl">
                <p class="text-base md:text-xl font-medium text-brandBase">
                    {!! $content->description ?? '' !!}
                </p>
            </div>

            <div class="mt-10">
                <a href="{{ route('wa.redirect') }}" target="_blank" rel="noopener noreferrer"
                   aria-label="Konsultasi Gratis melalui WhatsApp">
                    <button class="bg-[#05408C] hover:bg-[#05408C]/80 focus:ring-4 focus:ring-blue-300
                               ease-in duration-200 rounded-full flex py-4 px-6 md:py-5 md:px-8 gap-2 items-center">
                        <i class='bx bxl-whatsapp text-white text-2xl'></i>
                        <span class="font-medium text-base md:text-lg text-white">Konsultasi Gratis</span>
                    </button>
                </a>
            </div>
        </div>
    </section>
@endsection

{{-- =======================  FEATURES  ======================= --}}
@section('features')
    <section class="bg-[#05408C]/70 mb-[100px] max-w-full rounded-[20px] mt-[60px] px-6 py-12
                sm:px-10 md:px-16 lg:px-20 mx-5 lg:mx-20"
             role="region" aria-labelledby="features-title">
        <h2 id="features-title"
            class="text-white text-2xl sm:text-3xl md:text-4xl font-semibold text-center">
            Keunggulan Memilih Layanan Kami
        </h2>

        {{-- Mobile Slider --}}
        <div class="lg:hidden mt-14 overflow-hidden relative">
            <div id="feature-slider" class="flex transition-transform duration-500 ease-in-out w-full">
                @foreach ($whyUsList as $feature)
                    <article class="flex-shrink-0 w-full px-8 flex flex-col items-center text-center max-w-full"
                             aria-label="Keunggulan: {{ $feature->title }}">
                        <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center mx-auto">
                            <img src="{{ getWhyUsListImagePath($feature) }}"
                                 alt="Ikon {{ $feature->title }}" loading="lazy">
                        </figure>
                        <h3 class="font-medium text-lg text-white mt-4">{{ $feature->title }}</h3>
                    </article>
                @endforeach
            </div>

            {{-- Dots --}}
            <div id="feature-dots" class="flex justify-center mt-6 space-x-2">
                @foreach (range(0, count($whyUsList)-1) as $i)
                    <button class="w-3 h-3 rounded-full bg-white opacity-50"
                            aria-label="Slide ke {{ $i+1 }}"></button>
                @endforeach
            </div>
        </div>

        {{-- Desktop Grid --}}
        <div class="hidden lg:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6
                gap-y-12 gap-x-6 mt-14 justify-items-center">
            @foreach ($whyUsList as $feature)
                <article class="flex flex-col items-center text-center max-w-[160px]"
                         aria-label="Keunggulan: {{ $feature->title }}">
                    <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                        <img src="{{ getWhyUsListImagePath($feature) }}"
                             alt="Ikon {{ $feature->title }}" loading="lazy">
                    </figure>
                    <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">
                        {{ $feature->title }}
                    </h3>
                </article>
            @endforeach
        </div>
    </section>
@endsection

{{-- =======================  ABOUT  ======================= --}}
@section('about')
    <!-- About Section -->
    @php
        $content = json_decode($about->content);
    @endphp
    <section id="about"
             class="flex flex-col items-center justify-between lg:flex-row mx-5 lg:mx-20 my-16 md:my-[100px]"
             role="region" aria-labelledby="about-title">
        <div class="max-w-xl">
            <h2 id="about-title"
                class="text-baseBlack text-2xl text-center md:text-start md:text-4xl tracking-tight mb-4 font-bold">
                {!! $content->title !!}
            </h2>
            <p class="mt-6 text-base md:text-lg text-baseBlack">
                {!! $content->description !!}
            </p>

            @php
                $stats = old('content.stats', $content->stats ?? []);
                $stats = array_pad($stats, 3, (object)['title'=>'','value'=>'','suffix'=>'']);
            @endphp

            <div class="flex flex-row gap-1 items-center justify-between lg:flex-row pt-6 flex-wrap">
                @foreach (array_slice($stats,0,3) as $index=>$stat)
                    @if ($index>0)
                        <div class="hidden md:block w-px h-10 bg-gray-300"></div>
                    @endif
                    @php
                        $value=$stat->value??'';
                        $suffix=$stat->suffix??'';
                        $formatted = preg_match('/^[A-Za-z]/',$suffix)?$value.' '.$suffix:$value.$suffix;
                    @endphp
                    <div class="text-center" role="group" aria-label="{{ $stat->title }}">
                        <h3 class="text-baseBlack font-semibold text-xl md:text-2xl lg:text-3xl">
                            {{ $formatted }}
                        </h3>
                        <p class="text-baseBlack font-normal text-base md:text-xl">
                            {{ $stat->title }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <figure class="max-w-2xl mt-5 lg:mt-0 aspect-[16/9] overflow-hidden rounded-lg">
            <img class="object-cover w-full h-full"
                 src="{{ getAboutUsImageSection($content) }}"
                 alt="Foto Profil Proposal Studio">
        </figure>
    </section>
@endsection

{{-- =======================  SERVICES  ======================= --}}
@section('services')
    @php
        $content = json_decode($ourService->content);
    @endphp
    <section id="service"
             class="mx-5 my-14 md:mx-20 md:my-[100px]"
             role="region" aria-labelledby="services-title">
        <div class="lg:w-1/2 text-center mx-auto">
            <h2 id="services-title"
                class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center mb-6">
                {!! $content->title !!}
            </h2>
            <h3 class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
                {{ $content->subtitle }}
            </h3>
        </div>

        <div class="mt-8 md:mt-16 md:grid md:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <article class="py-6 px-2 flex flex-col items-center justify-center text-center"
                         aria-label="{{ $service->title }}">
                    <div class="mb-2">
                        <img src="{{ getServiceListImagePath($service) }}"
                             alt="Ikon {{ $service->title }}"
                             class="w-16 h-16 object-contain">
                    </div>
                    <h4 class="md:text-xl lg:text-2xl text-baseBlack font-semibold mt-2">
                        {{ $service->title }}
                    </h4>
                    <p class="font-normal md:text-sm lg:text-base text-baseBlack mt-3">
                        {{ $service->description }}
                    </p>
                </article>
            @endforeach
        </div>
    </section>
@endsection

{{-- =======================  CLIENTS / PROPOSAL  ======================= --}}
@section('clients')
    @php
        $content = json_decode($proposal->content);
    @endphp
    <section id="proposal"
             class="mx-5 my-14 md:mx-10"
             role="region" aria-labelledby="proposal-title">
        <h2 id="proposal-title"
            class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center mb-6">
            {!! $content->title !!}
        </h2>
        <p class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
            {{ $content->subtitle }}
        </p>

        {{-- Carousel --}}
        <div class="mt-8 md:mt-16 flex items-center justify-center gap-5">
            <button id="client-prev" aria-label="Klien sebelumnya"
                    class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center
                       justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-left-arrow-alt text-lg'></i>
            </button>

            <div class="relative flex-1 overflow-hidden">
                <div id="clientCarousel"
                     class="flex overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory px-0">
                    <div class="hidden md:block flex-shrink-0
                            w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]"></div>

                    @foreach ($proposals as $proposal)
                        <article class="flex-shrink-0 w-[calc(100%-16px)]
                                   md:w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]
                                   snap-start mx-2 border rounded-md"
                                 aria-label="{{ $proposal->title }}">
                            <div class="bg-white rounded-md hover:shadow-lg transition-shadow duration-300 p-4 flex items-center justify-center">
                                <img src="{{ getProposalListImagePath($proposal) }}"
                                     alt="{{ $proposal->title }}"
                                     class="w-full h-full object-cover rounded-md">
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <button id="client-next" aria-label="Klien selanjutnya"
                    class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center
                       justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </button>
        </div>
    </section>
@endsection

{{-- =======================  EVENTS  ======================= --}}
@section('events')
    @php
        $content = json_decode($event->content);
    @endphp
    <section id="event"
             class="mx-5 my-14 md:mx-10 bg-cover bg-center"
             style="background-image:url('https://raw.githubusercontent.com/vikifsyh/proposal-studio/main/public/bg2.png');"
             role="region" aria-labelledby="events-title">
        <h2 id="events-title"
            class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center mb-6">
            {!! $content->title !!}
        </h2>
        <p class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
            {{ $content->subtitle }}
        </p>

        {{-- Carousel --}}
        <div class="mt-8 md:mt-16 flex items-center justify-center gap-5">
            <button id="event-prev" aria-label="Acara sebelumnya"
                    class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center
                       justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-left-arrow-alt text-lg'></i>
            </button>

            <div class="relative flex-1 overflow-hidden">
                <div id="eventCarousel"
                     class="flex overflow-x-auto scroll-smooth no-scrollbar snap-x snap-mandatory px-0">
                    <div class="hidden md:block flex-shrink-0
                            w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]"></div>

                    @foreach ($events as $event)
                        <article class="flex-shrink-0 w-[calc(100%-16px)]
                                   md:w-[calc(50%-16px)] lg:w-[calc(33.3333%-16px)]
                                   snap-start mx-2 border rounded-md"
                                 aria-label="{{ $event->title }}">
                            <div class="bg-white rounded-md hover:shadow-lg transition-shadow duration-300
                                    p-4 flex flex-col items-start justify-start">
                                <img src="{{ getEventListImagePath($event) }}"
                                     alt="{{ $event->title }}"
                                     class="w-full h-full object-cover rounded-md">
                                <h4 class="text-baseBlack text-center text-base md:text-xl mt-4 line-clamp-2 font-semibold">
                                    {{ $event->title }}
                                </h4>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <button id="event-next" aria-label="Acara selanjutnya"
                    class="hidden lg:flex w-8 h-8 bg-white rounded-full border items-center
                       justify-center hover:bg-gray-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                <i class='bx bx-right-arrow-alt text-lg'></i>
            </button>
        </div>
    </section>
@endsection

{{-- =======================  REVIEWS  ======================= --}}
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

    <section id="reviews"
             class="my-24 mx-5 md:mx-20"
             role="region" aria-labelledby="reviews-title">
        <h2 id="reviews-title"
            class="text-gray-900 text-2xl md:text-4xl font-bold text-center">
            {!! $content->title !!}
        </h2>

        <div class="relative overflow-hidden mt-8 md:mt-16 pb-1">
            <div class="absolute top-0 left-0 w-32 h-full z-10 bg-gradient-to-r from-white to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-32 h-full z-10 bg-gradient-to-l from-white to-transparent pointer-events-none"></div>

            <div id="marquee-track" class="flex w-max gap-5 flex-nowrap will-change-transform">
                @foreach ($reviews as $review)
                    <figure class="w-[400px] h-auto rounded-[20px] px-8 py-7 border border-slate-200 bg-white flex-shrink-0"
                            aria-label="Testimoni {{ $review->name }}">
                        <figcaption class="flex gap-5 items-center">
                            <img src="{{ $review->image }}" alt="Foto {{ $review->name }}"
                                 class="w-14 h-14 rounded-full object-cover">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-800">{{ $review->name }}</span>
                                <span class="text-sm text-slate-500">{{ $review->company_name }}</span>
                            </div>
                        </figcaption>
                        <blockquote>
                            <p class="text-gray-600 text-base mt-6">{{ $review->comment }}</p>
                            <div class="flex gap-1 mt-5">{!! renderStars($review->rating) !!}</div>
                        </blockquote>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endsection

{{-- =======================  FAQ  ======================= --}}
@section('faqs')
    @php
        $content = json_decode($faq->content);
    @endphp
    <section id="faq"
             class="mx-5 my-14 md:mx-20 md:my-[100px] flex flex-col items-center justify-center"
             role="region" aria-labelledby="faq-title">
        <h2 id="faq-title"
            class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
            {!! $content->title !!}
        </h2>

        <div class="w-full max-w-6xl md:mt-10 mt-5">
            @foreach ($faqs as $faq)
                <details class="border-b border-gray-300 last:border-b-0 group">
                    <summary class="w-full flex items-center justify-between p-4 rounded-2xl transition-all
                                text-base md:text-xl font-medium text-baseBlack
                                hover:text-white hover:bg-brandPrimary">
                        {{ $faq->question }}
                        <i class="bx bx-chevron-down text-2xl transition-transform duration-200
                               group-open:rotate-180"></i>
                    </summary>
                    <div class="text-sm md:text-lg text-baseBlack font-normal mt-3 px-4 pb-4">
                        {{ $faq->answer }}
                    </div>
                </details>
            @endforeach
        </div>
    </section>
@endsection

{{-- =======================  CTA  ======================= --}}
@section('cta')
    @php
        $content = json_decode($callToAction->content);
    @endphp
    <section id="cta"
             class="md:mx-20 mx-5 mt-14 md:mt-[100px] md:mb-16 mb-8"
             role="region" aria-labelledby="cta-title">
        {{-- H2 hanya untuk aksesibilitas, sengaja disembunyikan --}}
        <h2 id="cta-title" class="sr-only">Ajakan Konsultasi</h2>

        <div class="bg-brandPrimary rounded-2xl md:rounded-[40px] p-8 md:p-16">
            <div class="lg:flex lg:items-center lg:justify-between lg:gap-20">
                <div class="text-center lg:text-left">
                    <h3 class="text-2xl lg:text-4xl text-white font-semibold mb-6">
                        {!! $content->title !!}
                    </h3>
                </div>

                <div class="flex justify-center lg:justify-end mt-6 lg:mt-0">
                    <a href="{{ route('wa.redirect') }}">
                        <button
                            class="flex gap-2 items-center justify-center px-4 py-2 bg-brandPrimary border border-white rounded-full
                               lg:px-8 lg:py-4 lg:gap-4
                               hover:bg-brandPrimary/50 ease-in-out duration-200 focus:ring-4
                               focus:ring-blue-300 focus:text-white hover:text-white
                               text-white whitespace-nowrap text-sm lg:text-xl">
                            Konsultasi Gratis
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 lg:w-6 lg:h-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
