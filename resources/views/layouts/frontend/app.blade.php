<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

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

    <title>{{ $title ?? env('APP_NAME') }}</title>

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
            <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}" />
            <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
        @else
            {{-- Fallback if manifest.json is missing --}}
            <p style="color: red;">Error: Build files not found. Please run <code>npm run build</code>.</p>
        @endif
    @endif

    @stack('styles')
    @stack('scripts')
</head>

<body class="bg-white text-black">
<header>
    @include('partials.frontend.navbar')
</header>

@yield('hero')
@yield('features')
@yield('about')

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
</body>

</html>
