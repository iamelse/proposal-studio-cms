@extends('layouts.app')

@section('content')
    <!-- ===== Main Content Start ===== -->
    <main>
        <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
            <!-- Header Section -->
            <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Review</h1>
                    <p class="text-gray-600 dark:text-gray-400">Update existing review.</p>
                </div>
            </div>

            <!-- Form Section -->
            <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
                <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <form action="{{ route('be.review.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $review->name) }}"
                                placeholder="Masukkan nama klien, contoh: Andi Pratama"
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('name') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>
                            @error('name')
                            <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Company Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="company_name"
                                id="company_name"
                                value="{{ old('company_name', $review->company_name) }}"
                                placeholder="Contoh: PT Maju Jaya Abadi"
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('company_name') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>
                            @error('company_name')
                            <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rating -->
                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="rating"
                                id="rating"
                                step="0.1"
                                max="5"
                                min="0"
                                value="{{ old('rating', $review->rating) }}"
                                placeholder="Berikan rating antara 0.0 hingga 5.0"
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('rating') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>
                            @error('rating')
                            <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Comment <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="comment"
                                id="comment"
                                rows="4"
                                placeholder="Tulis komentar dari klien di sini, contoh: Sangat puas dengan pelayanan yang diberikan..."
                                class="w-full text-sm mt-1 px-4 py-2 border rounded-lg bg-white dark:bg-gray-900
                                       border-gray-300 dark:border-gray-700 text-gray-800 dark:text-gray-300
                                       focus:ring focus:ring-blue-300
                                       @error('comment') border-red-500 focus:ring-red-300 dark:focus:ring-red-300 @enderror"
                                required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                            <p class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                    class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                                Update Review
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
    </script>
@endsection
