@php
    $currentUrl = url()->current();
    $isPostRoute = in_array(Route::currentRouteName(), ['fe.post.index', 'fe.post.show']);
@endphp

<nav id="navbar"
     class="px-5 lg:px-20 lg:py-4 py-2.5 flex justify-between items-center fixed top-0 w-full z-50
            bg-white/30 backdrop-blur-md backdrop-saturate-150 shadow-[0_1px_1px_rgba(0,0,0,0.1)] transition-colors duration-300">
    <!-- Logo (Desktop) -->
    <div class="hidden md:block">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-16 w-auto" />
    </div>
    <!-- Logo (Mobile) -->
    <div class="block md:hidden">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-13 w-auto" />
    </div>

    <!-- Desktop menu -->
    <div class="hidden lg:flex items-center gap-6 font-medium text-base lg:text-lg text-[#1f2328]">
        @if ($isPostRoute)
            <a href="{{ url('/') }}"
               class="hover:text-[#05408C] hover:underline underline-offset-4">
                Beranda
            </a>
        @else
            <a href="#home"
               class="nav-link hover:text-[#05408C] hover:underline underline-offset-4
                      {{ str_contains($currentUrl, '/#home') || $currentUrl === url('/') ? 'text-[#05408C] underline underline-offset-4' : '' }}">
                Beranda
            </a>

            <a href="#about" class="nav-link hover:text-[#05408C] hover:underline underline-offset-4">Tentang Kami</a>
            <a href="#service" class="nav-link hover:text-[#05408C] hover:underline underline-offset-4">Layanan Kami</a>
            <a href="#proposal" class="nav-link hover:text-[#05408C] hover:underline underline-offset-4">Klien</a>
            <a href="#event" class="nav-link hover:text-[#05408C] hover:underline underline-offset-4">Kegiatan</a>
        @endif

        <a href="{{ url('/post') }}"
           class="hover:text-[#05408C] hover:underline underline-offset-4
                  {{ str_contains($currentUrl, '/post') ? 'text-[#05408C] underline underline-offset-4' : '' }}">
            Artikel
        </a>
    </div>

    <!-- WhatsApp Button (Desktop) -->
    <a href="https://wa.me/{{ $settings['whatsapp_number_with_country_code'] }}?text=Hallo%20Kak%2C%20saya%20ingin%20tanya%20terkait%20proposal%2C%20apakah%20bisa%20dibantu%3F"
       target="_blank"
       class="hidden lg:block border border-[#05408C] px-5 py-3 text-[#05408C] font-medium rounded-full hover:bg-[#05408C] hover:text-white transition-all duration-300">
        Hubungi Kami
    </a>

    <!-- Mobile Buttons -->
    <div class="lg:hidden flex items-center gap-2">
        <a href="https://wa.me/{{ $settings['whatsapp_number_with_country_code'] }}" target="_blank"
           class="border border-[#05408C] py-2 px-4 text-sm text-[#05408C] font-medium rounded-full hover:bg-[#05408C] hover:text-white transition-all">
            Hubungi Kami
        </a>

        <!-- Hamburger Button -->
        <button id="hamburgerBtn" class="flex flex-col gap-[5px] z-50">
            <span class="h-[2px] w-5 bg-[#1f2328] rounded-full"></span>
            <span class="h-[2px] w-4 bg-[#1f2328] rounded-full"></span>
            <span class="h-[2px] w-5 bg-[#1f2328] rounded-full"></span>
        </button>
    </div>
</nav>

<!-- Mobile menu -->
<div id="mobileMenu" class="lg:hidden fixed top-[64px] left-0 right-0 z-40 bg-white border-t border-gray-200 transform -translate-y-[130%] transition-transform duration-500 ease-in-out">
    <div class="flex flex-col p-5 gap-6">
        @if ($isPostRoute)
            <a href="{{ url('/') }}"
               class="text-base font-medium hover:text-[#05408C]">
                Beranda
            </a>
        @else
            <a href="#home"
               class="nav-link-mobile text-base font-medium hover:text-[#05408C]
                      {{ str_contains($currentUrl, '/#home') || $currentUrl === url('/') ? 'text-[#05408C]' : '' }}">
                Beranda
            </a>

            <a href="#about" class="nav-link-mobile text-base font-medium hover:text-[#05408C]">Tentang Kami</a>
            <a href="#service" class="nav-link-mobile text-base font-medium hover:text-[#05408C]">Layanan Kami</a>
            <a href="#proposal" class="nav-link-mobile text-base font-medium hover:text-[#05408C]">Klien</a>
            <a href="#event" class="nav-link-mobile text-base font-medium hover:text-[#05408C]">Kegiatan</a>
        @endif

        <a href="{{ url('/post') }}"
           class="text-base font-medium hover:text-[#05408C]
                  {{ str_contains($currentUrl, '/post') ? 'text-[#05408C]' : '' }}">
            Artikel
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.getElementById('navbar');
        const navbarHeight = navbar.offsetHeight;
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.hidden.lg\\:flex a[href^="#"]'); // desktop links
        const mobileNavLinks = document.querySelectorAll('#mobileMenu a[href^="#"]'); // mobile links

        function clearActive() {
            navLinks.forEach(link => {
                link.classList.remove('text-[#05408C]', 'underline', 'underline-offset-4');
            });
            mobileNavLinks.forEach(link => {
                link.classList.remove('text-[#05408C]');
            });
        }

        function setActive(id) {
            navLinks.forEach(link => {
                if (link.getAttribute('href') === `#${id}`) {
                    link.classList.add('text-[#05408C]', 'underline', 'underline-offset-4');
                    // console.log(`Desktop link active: ${link.textContent.trim()}`);
                }
            });
            mobileNavLinks.forEach(link => {
                if (link.getAttribute('href') === `#${id}`) {
                    link.classList.add('text-[#05408C]');
                    // console.log(`Mobile link active: ${link.textContent.trim()}`);
                }
            });
        }

        function onScroll() {
            const scrollY = window.pageYOffset + navbarHeight + 10; // 10px padding for safety
            // console.log('ScrollY + offset:', scrollY);
            let currentSectionId = null;

            sections.forEach(section => {
                const top = section.offsetTop;
                const height = section.offsetHeight;
                const id = section.getAttribute('id');
                // console.log(`Checking section ${id}: top=${top}, height=${height}`);

                if (scrollY >= top && scrollY < top + height) {
                    currentSectionId = id;
                    // console.log(`Current active section detected: ${id}`);
                }
            });

            // If no section matched but scrollY is beyond last section top, activate last section
            if (!currentSectionId && scrollY >= sections[sections.length - 1].offsetTop) {
                currentSectionId = sections[sections.length - 1].getAttribute('id');
                // console.log(`Scrolled past last section, activate: ${currentSectionId}`);
            }

            if (currentSectionId) {
                clearActive();
                setActive(currentSectionId);
            } else {
                // console.log('No active section detected');
                clearActive();
            }
        }

        window.addEventListener('scroll', onScroll);
        onScroll(); // run once on load
    });
</script>
