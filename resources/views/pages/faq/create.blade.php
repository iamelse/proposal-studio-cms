@extends('layouts.app')

@section('content')
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Create New FAQ</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add a new FAQ.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.faq.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Question -->
                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Question <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="question"
                                id="question"
                                rows="4"
                                placeholder="Tulis pertanyaan dari klien di sini, contoh: Apa saja layanan yang tersedia?"
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('question') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>{{ old('question') }}</textarea>
                            @error('question')
                                <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Answer -->
                        <div class="mb-4">
                            <label for="answer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Answer <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="answer"
                                id="answer"
                                rows="4"
                                placeholder="Tulis jawaban untuk pertanyaan tersebut di sini"
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('answer') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>{{ old('answer') }}</textarea>
                            @error('answer')
                                <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                                Create FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- ===== Main Content End ===== -->
@endsection

@section('bottom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
