@extends('layouts.frontend.app')

@section('hero')
    <!-- Hero Section -->
    <section id="home" class="mt-24 md:mt-[170px] max-w-full mx-4 flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('assets/images/bg.png') }}')">
        <div class="text-center flex flex-col items-center mt-2 w-full">
            <header class="px-4 py-2 rounded-full md:px-4 md:py-3 border-2 border-brandSecondary bg-[#FAE8DF] w-fit">
                <p class="text-xs font-medium md:text-sm text-brandSecondary">
                    JASA PROPOSAL PROFESIONAL
                </p>
            </header>

            <div class="items-center mt-2 max-w-5xl">
                <h1 class="text-3xl md:text-5xl lg:text-7xl font-bold text-[#1f2328]">
                    Realisasikan Tujuanmu Bersama
                    <span class="text-brandPrimary"> PROPOSAL</span>
                    <span class="text-brandSecondary"> STUDIO</span>
                </h1>
            </div>

            <div class="mt-[14px] max-w-4xl">
                <p class="text-base md:text-xl font-medium text-[#1f2328]">
                    “Percayakan kesuksesan proposal Anda kepada kami. Tim profesional dan berpengalaman dari kami akan membantu Anda meraih kesuksesan yang lebih besar”
                </p>
            </div>

            <div class="mt-10">
                <a href="https://wa.me/6281226831649?text=Hallo%20Kak%2C%20saya%20ingin%20tanya%20terkait%20proposal%2C%20apakah%20bisa%20dibantu%3F" target="_blank" rel="noopener noreferrer">
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
    <section class="hidden lg:block bg-[#05408C]/70 mb-[100px] max-w-full rounded-[20px] mt-[60px] px-6 py-12 sm:px-10 md:px-16 lg:px-20 mx-5 lg:mx-20">
        <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-semibold text-center">
            Keunggulan Memilih Layanan Kami
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-12 gap-x-6 mt-14 justify-items-center">
            <!-- Feature Item -->
            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/trusted.svg') }}" alt="Terpercaya">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Terpercaya</h3>
            </article>

            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/proffesional-teams.svg') }}" alt="Tim Profesional">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Tim Profesional</h3>
            </article>

            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/fast.svg') }}" alt="Pengerjaan Cepat">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Pengerjaan Cepat</h3>
            </article>

            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/free-consultation.svg') }}" alt="Gratis Konsultasi">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Gratis Konsultasi</h3>
            </article>

            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/free-revision.svg') }}" alt="Bebas Revisi">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Bebas Revisi</h3>
            </article>

            <article class="flex flex-col items-center text-center max-w-[160px]">
                <figure class="rounded-full bg-white p-5 w-[108px] h-[108px] flex items-center justify-center">
                    <img src="{{ asset('assets/images/why-us/good-service.svg') }}" alt="Pelayanan Ramah">
                </figure>
                <h3 class="font-medium text-base sm:text-lg md:text-xl text-white mt-3 break-words">Pelayanan Ramah</h3>
            </article>
        </div>
    </section>
@endsection

@section('about')
    <!-- About Section -->
    <section id="about" class="flex flex-col items-center justify-between lg:flex-row mx-5 lg:mx-20 my-16 md:my-[100px]">
        <div class="max-w-xl">
            <h2 class="text-baseBlack text-2xl md:text-4xl tracking-tight mb-4 font-bold">
                <span class="text-brandPrimary">PROPOSAL</span>
                <span class="text-brandSecondary"> STUDIO</span>
                Keberhasilan project Anda adalah prioritas kami
            </h2>
            <p class="mt-6 text-base md:text-lg text-baseBlack">
                Proposal Studio adalah jasa pembuatan proposal komersial yang berdiri sejak Januari, 2022. Kami telah dipercaya
                mengerjakan banyak project regional maupun project nasional oleh bermacam perusahaan, lembaga, event organizer,
                business owner, cerative agency, dan influencer. Kami juga telah dipercaya mengisi materi proposal di organisasi
                maupun komunitas di beberapa kampus ternama di Indonesia.
            </p>

            <div class="flex flex-row gap-1 items-center justify-between lg:flex-row pt-6 flex-wrap">
                <div class="text-center">
                    <h3 class="text-baseBlack font-semibold text-xl md:text-2xl lg:text-3xl">250+</h3>
                    <p class="text-baseBlack font-normal text-base md:text-xl">Projek Selesai</p>
                </div>
                <div class="hidden md:block w-px h-10 bg-gray-300"></div>
                <div class="text-center">
                    <h3 class="text-baseBlack font-semibold text-xl md:text-2xl lg:text-3xl">2 Tahun+</h3>
                    <p class="text-baseBlack font-normal text-base md:text-xl">Pengalaman Kerja</p>
                </div>
                <div class="hidden md:block w-px h-10 bg-gray-300"></div>
                <div class="text-center">
                    <h3 class="text-baseBlack font-semibold text-xl md:text-2xl lg:text-3xl">99%</h3>
                    <p class="text-baseBlack font-normal text-base md:text-xl">Klien Puas</p>
                </div>
            </div>
        </div>
        <figure class="max-w-xl mt-5 lg:mt-0">
            <img class="object-cover w-full h-full rounded-lg" src="https://www.proposal-studio.com/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Fprofil.26ea71de.jpg&w=3840&q=75" alt="Foto Profil Proposal Studio">
        </figure>
    </section>

    <section id="service" class="mx-5 my-14 md:mx-20 md:my-[100px]">
        @php
            $services = [
            [
                'id' => 1,
                'icon' => 'bisnis.svg', // Example icon
                'title' => 'Proposal Bisnis',
                'desc' => 'Dokumen rinci yang merencanakan dan meyakinkan tentang potensi kesuksesan suatu bisnis.',
            ],
            [
                'id' => 2,
                'icon' => 'kegiatan.svg', // Example icon
                'title' => 'Proposal Kegiatan',
                'desc' => 'Dokumen yang merinci rencana dan pelaksanaan suatu kegiatan atau acara untuk mendapatkan persetujuan dan dukungan.',
            ],
            [
                'id' => 3,
                'icon' => 'sponsorship.svg', // Example icon
                'title' => 'Proposal Sponsorship',
                'desc' => 'Dokumen permohonan dukungan finansial dari sponsor untuk suatu acara atau inisiatif tertentu.',
            ],
            [
                'id' => 4,
                'icon' => 'investasi.svg', // Example icon
                'title' => 'Proposal Investasi',
                'desc' => 'Dokumen yang merinci potensi keuntungan dan proyeksi keuangan suatu investasi untuk meyakinkan para investor.',
            ],
            [
                'id' => 5,
                'icon' => 'kerjasama.svg', // Example icon
                'title' => 'Proposal Kerjasama',
                'desc' => 'Dokumen formal yang merinci tujuan, manfaat, dan syarat-syarat kerjasama antara pihak-pihak terlibat.',
            ],
            [
                'id' => 6,
                'icon' => 'sewa-tempat.svg', // Example icon
                'title' => 'Proposal Sewa Tempat',
                'desc' => 'Dokumen permohonan dan rincian kontrak penyewaan untuk mendapatkan persetujuan penyewaan tempat.',
            ],
            [
                'id' => 7,
                'icon' => 'penawaran-produk.svg',
                'title' => 'Proposal Penawaran Produk',
                'desc' => 'Dokumen yang merinci informasi produk, harga, dan manfaat untuk mendapatkan persetujuan pembelian dari calon pelanggan.'
            ],
            [
                'id' => 8,
                'icon' => 'company-profile.svg', // Example icon
                'title' => 'Company Profile',
                'desc' => 'Dokumen ringkas yang menyajikan informasi mengenai identitas, visi, misi, nilai-nilai, dan pencapaian perusahaan.',
            ],
            [
                'id' => 9,
                'icon' => 'curriculum-vitae.svg', // Example icon
                'title' => 'Curriculum Vitae',
                'desc' => 'Ringkasan tertulis tentang latar belakang pendidikan, pengalaman kerja, dan keterampilan seseorang.',
            ],
        ];
        @endphp
        <div class="lg:w-1/2 text-center mx-auto">
            <h1 class="text-baseBlack text-2xl md:text-4xl tracking-tight font-bold text-center">
                Mewujudkan Ide Brilian Anda Melalui Proposal Yang Mengesankan
            </h1>
            <h2 class="mt-1 lg:mt-3 text-center font-semibold text-lg md:text-xl text-baseBlack">
                Temukan Layanan Profesional yang Tepat di Proposal Studio.
            </h2>
        </div>

        <div class="mt-8 md:mt-16 md:grid md:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <article class="py-6 px-2 flex flex-col items-center justify-center text-center">
                    <div class="mb-2">
                        <img src="{{ asset('assets/images/services/proposals/' . $service['icon']) }}" alt="{{ $service['title'] }}" class="w-16 h-16 object-contain">
                    </div>
                    <h2 class="md:text-xl lg:text-2xl text-baseBlack font-semibold mt-2">
                        {{ $service['title'] }}
                    </h2>
                    <p class="font-normal md:text-sm lg:text-base text-baseBlack mt-3">
                        {{ $service['desc'] }}
                    </p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
