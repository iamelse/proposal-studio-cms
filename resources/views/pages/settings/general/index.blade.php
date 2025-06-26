@php
    use App\Enums\PermissionEnum;
@endphp

@extends('layouts.app')

@section('content')
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        General Settings
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Manage your contact details and business hours to ensure your website displays accurate and up-to-date information to visitors.
                    </p>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.settings.general.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Contact -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class='bx bx-phone text-xl'></i> Contact
                            </h2>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="whatsapp" name="settings[whatsapp]" placeholder="+62xxxxxxxxxxx"
                                           value="{{ old('settings.whatsapp', $settings['whatsapp'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.whatsapp') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.whatsapp')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" id="email" name="settings[email]" placeholder="example@email.com"
                                           value="{{ old('settings.email', $settings['email'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.email') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.email')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mt-8">
                                <i class='bx bx-time text-xl'></i> Business Hours
                            </h2>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="working_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Working Hours <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="working_hours" name="settings[working_hours]" placeholder="08.00 - 17.00"
                                           value="{{ old('settings.working_hours', $settings['working_hours'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.working_hours') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.working_hours')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="off_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Days Off <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="off_days" name="settings[off_days]" placeholder="Sabtu, Minggu, Hari Libur Nasional"
                                           value="{{ old('settings.off_days', $settings['off_days'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.off_days') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.off_days')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Identity & SEO -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mt-8">
                                <i class='bx bx-globe text-xl'></i> Identity & SEO
                            </h2>

                            <div class="mt-4 space-y-4">
                                <!-- Site Logo -->
                                <div>
                                    <label for="site_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Site Logo
                                    </label>
                                    <input class="mt-1 block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none
                                       {{ $errors->has('settings.site_logo') ? 'border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500' : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-blue-500 dark:focus:ring-blue-500' }}"
                                           id="site_logo" name="settings[site_logo]" type="file" accept="image/*"
                                           onchange="previewImage(event, 'preview_site_logo')">
                                    <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-300" id="image_help">
                                        Accepted formats: <span class="font-semibold text-gray-700 dark:text-gray-200">JPG, PNG, SVG</span>, or any valid image file. Max size: <span class="font-semibold text-gray-700 dark:text-gray-200">2MB</span>.
                                    </p>
                                    @error('settings.site_logo')
                                        <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror

                                    <div class="mt-2">
                                        @if (!empty($settings['site_logo']))
                                            <img id="preview_site_logo" src="{{ getLogoImagePath($settings) }}" alt="Site Logo" class="h-24 rounded">
                                        @else
                                            <img id="preview_site_logo" class="h-24 rounded hidden" />
                                        @endif
                                    </div>
                                </div>

                                <!-- OG Image - Home -->
                                <div>
                                    <label for="og_image_home" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        OG Image - Home
                                    </label>
                                    <input class="mt-1 block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none
                                       {{ $errors->has('settings.og_image_home') ? 'border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500' : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-blue-500 dark:focus:ring-blue-500' }}"
                                           id="og_image_home" name="settings[og_image_home]" type="file" accept="image/*"
                                           onchange="previewImage(event, 'preview_og_home')">
                                    <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-300" id="image_help">
                                        Accepted formats: <span class="font-semibold text-gray-700 dark:text-gray-200">JPG, PNG, SVG</span>, or any valid image file. Max size: <span class="font-semibold text-gray-700 dark:text-gray-200">2MB</span>.
                                    </p>
                                    @error('settings.og_image_home')
                                        <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror

                                    <div class="mt-2">
                                        @if (!empty($settings['og_image_home']))
                                            <img id="preview_og_home" src="{{ getOgImageHomePath($settings) }}" alt="OG Home" class="h-24 rounded">
                                        @else
                                            <img id="preview_og_home" class="h-24 rounded hidden" />
                                        @endif
                                    </div>
                                </div>

                                <!-- OG Image - Post Index -->
                                <div>
                                    <label for="og_image_post_index" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        OG Image - Post Index
                                    </label>
                                    <input class="mt-1 block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none
                                        {{ $errors->has('settings.og_image_post_index') ? 'border-red-500 dark:border-red-500 focus:ring-red-500 dark:focus:ring-red-500' : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-blue-500 dark:focus:ring-blue-500' }}"
                                           id="og_image_post_index" name="settings[og_image_post_index]" type="file" accept="image/*"
                                           onchange="previewImage(event, 'preview_og_post_index')">
                                    <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-300" id="image_help">
                                        Accepted formats: <span class="font-semibold text-gray-700 dark:text-gray-200">JPG, PNG, SVG</span>, or any valid image file. Max size: <span class="font-semibold text-gray-700 dark:text-gray-200">2MB</span>.
                                    </p>
                                    @error('settings.og_image_post_index')
                                        <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror

                                    <div class="mt-2">
                                        @if (!empty($settings['og_image_post_index']))
                                            <img id="preview_og_post_index" src="{{ getOgImagePostIndexPath($settings) }}" alt="OG Post Index" class="h-24 rounded">
                                        @else
                                            <img id="preview_og_post_index" class="h-24 rounded hidden" />
                                        @endif
                                    </div>
                                </div>

                                <!-- SEO Title - Home -->
                                <div>
                                    <label for="home_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        SEO Title - Home Page <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="home_title" name="settings[home_title]" placeholder="Contoh: Selamat Datang di Nama Website"
                                           value="{{ old('settings.home_title', $settings['home_title'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.home_title') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.home_title')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="home_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        SEO Description - Home Page
                                    </label>
                                    <textarea id="home_description" name="settings[home_description]" rows="3"
                                              placeholder="Deskripsi singkat untuk halaman utama situs"
                                              class="w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                          {{ $errors->has('settings.home_description') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                          bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">{{ old('settings.home_description', $settings['home_description'] ?? '') }}</textarea>
                                    @error('settings.home_description')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- SEO Title - Post Index -->
                                <div>
                                    <label for="post_index_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        SEO Title - Post Index <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="post_index_title" name="settings[post_index_title]" placeholder="Contoh: Artikel & Berita Terbaru"
                                           value="{{ old('settings.post_index_title', $settings['post_index_title'] ?? '') }}"
                                           class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                       {{ $errors->has('settings.post_index_title') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                       bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                                    @error('settings.post_index_title')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="post_index_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        SEO Description - Post Index
                                    </label>
                                    <textarea id="post_index_description" name="settings[post_index_description]" rows="3"
                                              placeholder="Deskripsi untuk halaman artikel/blog"
                                              class="w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                          {{ $errors->has('settings.post_index_description') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                          bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300">{{ old('settings.post_index_description', $settings['post_index_description'] ?? '') }}</textarea>
                                    @error('settings.post_index_description')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('bottom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 shadow-lg',
                        title: 'font-normal text-base text-gray-800 dark:text-gray-200'
                    }
                });
            @endif

            @if($errors->any() || session('error'))
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: "{{ session('error') ?? 'Something went wrong. Please check the form and try again.' }}",
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-gray-800 shadow-lg',
                        title: 'font-normal text-base text-gray-800 dark:text-gray-200'
                    }
                });
            @endif
        });

        function previewImage(event, targetId) {
            const file = event.target.files[0];
            const preview = document.getElementById(targetId);

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        }
    </script>
@endsection
