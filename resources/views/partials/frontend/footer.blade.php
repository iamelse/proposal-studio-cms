<div class="mx-2 md:mx-10">
    <div class="pt-14 pb-10 px-5 md:px-10 lg:px-[120px] bg-brandBase rounded-t-2xl lg:rounded-t-3xl">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-center items-center">
                <div class="hidden md:block">
                    {{-- Boxicons Proposal Studio icon substitute: You might want to use a relevant boxicon or your own SVG --}}
                    <img src="{{ getLogoImagePath($settings) }}" alt="Proposal Studio Logo" />
                </div>
                <div class="block md:hidden">
                    <img src="{{ getLogoImagePath($settings) }}" alt="Proposal Studio Logo" />
                </div>
            </div>

            <div class="lg:flex lg:justify-between">
                <div class="mt-8 lg:mt-16">
                    <h2 class="font-semibold text-base md:text-lg text-white">Jam Kerja</h2>
                    <div class="flex gap-3 mt-3 lg:mt-6 items-center">
                        <i class='bx bx-time-five text-white text-2xl'></i>
                        <p class="text-white text-sm md:text-lg font-light">{{ $settings['working_hours'] }}</p>
                    </div>
                    <div class="flex gap-3 mt-3 lg:mt-6 items-center">
                        <i class='bx bx-calendar text-white text-2xl'></i>
                        <p class="text-white text-sm md:text-lg font-light">{{ $settings['off_days'] }}</p>
                    </div>
                </div>

                <div class="mt-8 lg:mt-16">
                    <h2 class="font-semibold text-base md:text-lg text-white">Kontak Kami</h2>
                    <div class="flex gap-3 mt-3 lg:mt-6 items-center">
                        <i class='bx bxl-whatsapp text-white text-2xl'></i>
                        <p class="text-white text-sm md:text-lg font-light">Whatsapp: {{ $settings['whatsapp'] }}</p>
                    </div>
                    <div class="flex gap-3 mt-3 lg:mt-6 items-center">
                        <i class='bx bx-envelope text-white text-2xl'></i>
                        <p class="text-white text-sm md:text-lg font-light">{{ $settings['email'] }}</p>
                    </div>
                </div>

                <div class="mt-8 lg:mt-16">
                    <h2 class="font-semibold text-base md:text-lg text-white">Sosial Media</h2>
                    <div class="flex gap-3 mt-3 md:mt-6">
                        @foreach($socialMedia as $item)
                            <a href="{{ $item->url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-white hover:text-secondary transition text-3xl"
                               aria-label="{{ $item->name }}">
                                <i class='bx {{ $item->icon }}'></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-center items-center mt-16">
                <h2 class="text-xs md:text-base text-gray-400 text-center">
                    COPYRIGHT PROPOSAL STUDIO {{ date('Y') }} © ALL RIGHT RESERVED
                </h2>
            </div>
        </div>
    </div>
</div>
