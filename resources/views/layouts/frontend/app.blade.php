<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Meta Robots -->
    <meta name="robots" content="index, follow">

    <!-- Standard Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicons/favicon.ico') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/favicons/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('assets/images/favicons/android-chrome-512x512.png') }}">

    <!-- Manifest for PWA -->
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}">

    <!-- Boxicons -->
    <link rel="preload" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
          as="style" onload="this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
              href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    </noscript>

    {{-- ── Preload Outfit font family ───────────────────────────────── --}}
    <link rel="preload" href="{{ asset('assets/fonts/outfit/subset-Outfit-Regular.woff2') }}"
          as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/outfit/subset-Outfit-Bold.woff2') }}"
          as="font" type="font/woff2" crossorigin>
    {{-- ─────────────────────────────────────────────────────────────── --}}

    {{-- Preload Background --}}
    <link rel="preload" as="image" href="{{ asset('assets/images/bg.webp') }}">

    @php
        use Illuminate\Support\Facades\App;

        $environment = App::environment();
    @endphp

    @if ($environment === 'local')
        {{-- Use Vite Dev Server --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Load Production or Staging Build --}}
        @php
            $manifestPath = public_path('build/manifest.json');
            $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;
        @endphp

        @if ($manifest && isset($manifest['resources/css/app.css'], $manifest['resources/js/app.js']))
            {{-- CSS — non-blocking preload trick --}}
            <link rel="preload" as="style"
                  href="{{ asset('build/'.$manifest['resources/css/app.css']['file']) }}"
                  onload="this.onload=null;this.rel='stylesheet'">
            <noscript>
                <link rel="stylesheet"
                      href="{{ asset('build/'.$manifest['resources/css/app.css']['file']) }}">
            </noscript>

            {{-- JS — module sudah defer; tambah defer utk non-module fallback --}}
            <script src="{{ asset('build/'.$manifest['resources/js/app.js']['file']) }}" defer></script>
        @else
            {{-- Fallback if manifest.json is missing --}}
            <p style="color: red;">Error: Build files not found. Please run <code>npm run build</code>.</p>
        @endif
    @endif

    @stack('styles')
    @stack('scripts')
    @stack('meta')
</head>

<body class="bg-white text-black">
<header>
    @include('partials.frontend.navbar')
</header>

@yield('hero')
@yield('features')
@yield('about')
@yield('services')
@yield('clients')
@yield('events')
@yield('reviews')
@yield('faqs')
@yield('cta')

@include('partials.frontend.footer')

<script>
    const hamburger = document.getElementById("hamburgerBtn");
    const menu = document.getElementById("mobileMenu");
    const navbar = document.getElementById("navbar");
    let open = false;

    hamburger.addEventListener("click", () => {
        open = !open;
        hamburger.classList.toggle("open", open);
        menu.classList.toggle("-translate-y-[130%]");
        menu.classList.toggle("translate-y-0");

        if (open) {
            navbar.classList.add("border-transparent");
            navbar.classList.remove("border-gray-200");
        } else {
            navbar.classList.add("border-gray-200");
            navbar.classList.remove("border-transparent");
        }
    });
</script>
<script>
    const slider = document.getElementById('feature-slider');
    const dots = document.querySelectorAll('#feature-dots button');
    const originalSlides = slider.children.length;
    let index = 0;
    let autoSlide;

    function cloneSlide(slideIndex) {
        const slide = slider.children[slideIndex].cloneNode(true);
        slider.appendChild(slide);
    }

    function updateDots() {
        // Only show the correct dot relative to original slides
        dots.forEach((dot, i) => {
            dot.classList.toggle('opacity-100', i === (index % originalSlides));
            dot.classList.toggle('opacity-50', i !== (index % originalSlides));
        });
    }

    function slideNext() {
        index++;

        // If needed, clone the next slide (to keep growing)
        if (index >= slider.children.length) {
            cloneSlide(index % originalSlides);
        }

        slider.style.transition = 'transform 0.5s ease-in-out';
        slider.style.transform = `translateX(-${index * 100}%)`;
        updateDots();
    }

    function goToSlide(i) {
        index = i;
        slider.style.transition = 'transform 0.5s ease-in-out';
        slider.style.transform = `translateX(-${index * 100}%)`;
        updateDots();
    }

    // Handle dot clicks
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            clearInterval(autoSlide);
            goToSlide(i);
            autoSlide = setInterval(slideNext, 2000);
        });
    });

    // Start autoplay
    updateDots();
    autoSlide = setInterval(slideNext, 2000);
</script>
<script>
    const clientCarousel = document.getElementById('clientCarousel');
    const clientPrevBtn = document.getElementById('client-prev');
    const clientNextBtn = document.getElementById('client-next');

    function updateButtons() {
        const spacer = clientCarousel.querySelector('div:last-child');
        const spacerWidth = spacer ? spacer.offsetWidth : 0;

        const maxScrollLeft = clientCarousel.scrollWidth - clientCarousel.clientWidth - spacerWidth;
        const currentScroll = clientCarousel.scrollLeft;

        clientPrevBtn.disabled = currentScroll <= 0;
        clientNextBtn.disabled = currentScroll >= maxScrollLeft - 1;
    }

    function getCardWidth() {
        const firstCard = clientCarousel.querySelector('.flex-shrink-0');
        if (!firstCard) return 0;
        const style = window.getComputedStyle(firstCard);
        const margin = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
        return firstCard.offsetWidth + margin;
    }

    clientPrevBtn.addEventListener('click', () => {
        clientCarousel.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
    });

    clientNextBtn.addEventListener('click', () => {
        clientCarousel.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
    });

    clientCarousel.addEventListener('scroll', updateButtons);
    window.addEventListener('load', updateButtons);
    window.addEventListener('resize', updateButtons);
</script>
<script>
    const eventCarousel = document.getElementById('eventCarousel');
    const eventPrevBtn = document.getElementById('event-prev')
    const eventNextBtn = document.getElementById('event-next');

    function updateButtons() {
        const maxScrollLeft = eventCarousel.scrollWidth - eventCarousel.clientWidth;
        eventPrevBtn.disabled = eventCarousel.scrollLeft <= 0;
        eventNextBtn.disabled = eventCarousel.scrollLeft >= maxScrollLeft - 1;
    }

    function getCardWidth() {
        // Get width of first visible card including margin
        const firstCard = eventCarousel.querySelector('div');
        const style = window.getComputedStyle(firstCard);
        const margin = parseFloat(style.marginLeft) + parseFloat(style.marginRight);
        return firstCard.offsetWidth + margin;
    }

    eventPrevBtn.addEventListener('click', () => {
        eventCarousel.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
    });

    eventNextBtn.addEventListener('click', () => {
        eventCarousel.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
    });

    eventCarousel.addEventListener('scroll', updateButtons);
    window.addEventListener('load', updateButtons);
    window.addEventListener('resize', updateButtons);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const contentId = button.getAttribute('data-target');
                const content = document.getElementById(contentId);
                const isOpen = button.getAttribute('aria-expanded') === 'true';
                const icon = button.querySelector('i.bx');

                if (isOpen) {
                    content.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                    icon.classList.remove('rotate-180');
                } else {
                    content.classList.remove('hidden');
                    button.setAttribute('aria-expanded', 'true');
                    icon.classList.add('rotate-180');
                }
            });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const track = document.getElementById('marquee-track');
        const wrapper = track.parentElement;

        // Duplikasi isi track
        track.innerHTML += track.innerHTML;

        let position = 0;
        let speed = 0.8; // Semakin kecil = semakin lambat
        let trackWidth = track.scrollWidth / 2;

        function animate() {
            position -= speed;
            if (Math.abs(position) >= trackWidth) {
                position = 0; // reset ke awal
            }
            track.style.transform = `translateX(${position}px)`;
            requestAnimationFrame(animate);
        }

        // Optimasi performa
        track.style.willChange = "transform";
        track.style.backfaceVisibility = "hidden";

        animate();
    });
</script>
</body>

</html>
