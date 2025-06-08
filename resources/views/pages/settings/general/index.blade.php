@php
    use App\Enums\PermissionEnum;
@endphp

@extends('layouts.app')

@section('content')
    <!-- ===== General Settings Section Start ===== -->
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

                <!-- Shortcut Button -->
                <div>
                    <!-- Kosongkan atau tambahkan tombol jika diperlukan -->
                </div>
            </div>

            <!-- Hero Section Form -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.settings.general.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Kontak Section -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                                <i class='bx bx-phone text-xl'></i> Kontak
                            </h2>

                            <div class="mt-4 space-y-4">
                                <!-- WhatsApp -->
                                <div>
                                    <label for="whatsapp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="whatsapp"
                                        name="settings[whatsapp]"
                                        placeholder="+62xxxxxxxxxxx"
                                        value="{{ old('settings.whatsapp', $settings['whatsapp'] ?? '') }}"
                                        class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                            {{ $errors->has('settings.whatsapp') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                            bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                                    >
                                    @error('settings.whatsapp')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="settings[email]"
                                        placeholder="example@email.com"
                                        value="{{ old('settings.email', $settings['email'] ?? '') }}"
                                        class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                            {{ $errors->has('settings.email') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                            bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                                    >
                                    @error('settings.email')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Jam Kerja Section -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center gap-2 mt-8">
                                <i class='bx bx-time text-xl'></i> Jam Kerja
                            </h2>

                            <div class="mt-4 space-y-4">
                                <!-- Jam Kerja -->
                                <div>
                                    <label for="working_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Jam Kerja <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="working_hours"
                                        name="settings[working_hours]"
                                        placeholder="08.00 - 17.00"
                                        value="{{ old('settings.working_hours', $settings['working_hours'] ?? '') }}"
                                        class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                            {{ $errors->has('settings.working_hours') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                            bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                                    >
                                    @error('settings.working_hours')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Hari Libur -->
                                <div>
                                    <label for="off_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Hari Libur <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="off_days"
                                        name="settings[off_days]"
                                        placeholder="Sabtu, Minggu, Hari Libur Nasional"
                                        value="{{ old('settings.off_days', $settings['off_days'] ?? '') }}"
                                        class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg placeholder:text-gray-400 dark:placeholder:text-white/30
                                            {{ $errors->has('settings.off_days') ? 'border-red-500 dark:border-red-500 focus:ring-red-500' : 'border-gray-300 dark:border-gray-700' }}
                                            bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300"
                                    >
                                    @error('settings.off_days')
                                    <span class="text-xs mt-1 text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
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
    <!-- ===== General Settings Section End ===== -->
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

            @if(session('error'))
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: "{{ session('error') }}",
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
    </script>
@endsection
