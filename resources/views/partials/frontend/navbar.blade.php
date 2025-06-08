<nav id="navbar"
     class="px-5 lg:px-20 lg:py-4 border py-2.5 flex justify-between items-center fixed top-0 w-full z-50 bg-white transition-colors duration-300">
    <!-- Logo (Desktop) -->
    <div class="hidden md:block">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-15 w-auto" />
    </div>
    <!-- Logo (Mobile) -->
    <div class="block md:hidden">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="h-13 w-auto" />
    </div>

    <!-- Navigation Links -->
    <div class="hidden lg:flex items-center gap-6 font-medium text-base lg:text-lg text-[#1f2328]">
        <a href="#home" class="hover:text-[#05408C] hover:underline underline-offset-4">Beranda</a>
        <a href="#about" class="hover:text-[#05408C] hover:underline underline-offset-4">Tentang Kami</a>
        <a href="#service" class="hover:text-[#05408C] hover:underline underline-offset-4">Layanan Kami</a>
        <a href="#proposal" class="hover:text-[#05408C] hover:underline underline-offset-4">Klien</a>
        <a href="#event" class="hover:text-[#05408C] hover:underline underline-offset-4">Kegiatan</a>
        <a href="#article" class="hover:text-[#05408C] hover:underline underline-offset-4">Artikel</a>
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

<!-- Mobile Dropdown Menu -->
<div id="mobileMenu"
     class="fixed top-[64px] left-0 right-0 z-40 bg-white border-t border-gray-200 transform -translate-y-[130%] transition-transform duration-500 ease-in-out lg:hidden">
    <div class="flex flex-col p-5 gap-6">
        <a href="#home" class="text-base font-medium hover:text-[#05408C]">Beranda</a>
        <a href="#about" class="text-base font-medium hover:text-[#05408C]">Tentang Kami</a>
        <a href="#service" class="text-base font-medium hover:text-[#05408C]">Layanan Kami</a>
        <a href="#proposal" class="text-base font-medium hover:text-[#05408C]">Klien</a>
        <a href="#event" class="text-base font-medium hover:text-[#05408C]">Kegiatan</a>
        <a href="#artikel" class="text-base font-medium hover:text-[#05408C]">Artikel</a>
    </div>
</div>
