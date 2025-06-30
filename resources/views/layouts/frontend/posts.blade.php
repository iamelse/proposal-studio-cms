<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Meta Robots -->
    <meta name="robots" content="index, follow">

    <!-- Root Favicon -->
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <!-- Standard Favicons -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/images/favicons/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('assets/images/favicons/android-chrome-512x512.png') }}">

    <!-- Manifest for PWA -->
    <link rel="manifest" href="{{ asset('assets/images/favicons/site.webmanifest') }}">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
    @stack('meta')
</head>

<body class="bg-white text-black">
<header>
    @include('partials.frontend.navbar')
</header>

@yield('content')

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
</body>

</html>
