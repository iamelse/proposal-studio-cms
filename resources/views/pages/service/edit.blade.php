@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Service</h1>
                <p class="text-gray-600 dark:text-gray-400">Update service details.</p>
            </div>
        </div>

        <!-- Form Section -->
        <div x-data="slugGenerator('{{ old('title', $service->title ?? '') }}', '{{ old('slug', $service->slug ?? '') }}')" class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.our-service-list.update', $service->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mt-4" x-data="{ hasError: {{ session('errors') && session('errors')->has('title') ? 'true' : 'false' }} }">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Title <span class="text-error-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            x-model="title"
                            placeholder="e.g., Proposal Bisnis, Proposal Kegiatan, Proposal Sponsorship"
                            @input.debounce.300ms="updateSlug"
                            :class="hasError
                                ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500'
                                : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                            class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2"
                            required>
                        @error('title')
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mt-4" x-data="{ hasError: {{ session('errors') && session('errors')->has('slug') ? 'true' : 'false' }} }">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Slug <span class="text-error-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            x-model="slug"
                            placeholder="Slug will be generated automatically from the name you provided."
                            :class="hasError
                                ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500'
                                : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                            class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2"
                            readonly
                            required>
                        @error('slug')
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">* {{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Order <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('order') ? 'true' : 'false' }} }">
                            <input
                                type="number"
                                id="order"
                                name="order"
                                min="1"
                                value="{{ old('order', $service->order) }}"
                                placeholder="e.g., 1, 2, 3..."
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                                class="h-11 w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2"
                                required>
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('order') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-4">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Description <span class="text-error-500">*</span>
                        </label>
                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('description') ? 'true' : 'false' }} }">
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Enter a detailed description..."
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-red-500 focus:border-red-500'
                                    : 'border-gray-300 dark:border-gray-700 focus:ring-blue-500 focus:border-blue-500'"
                                class="w-full text-sm mt-1 px-4 py-2.5 border rounded-lg bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:ring-2">{{ old('description', $service->description ?? '') }}</textarea>
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('description') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- Image Upload (Edit) -->
                    <div class="mt-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">
                            Upload file
                        </label>

                        <div x-data="{ hasError: {{ session('errors') && session('errors')->has('image') ? 'true' : 'false' }} }">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="image_help"
                                id="image"
                                name="image"
                                type="file"
                                accept="image/*"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                            >
                            <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-300" id="image_help">
                                Accepted formats: <span class="font-semibold text-gray-700 dark:text-gray-200">JPG, PNG, SVG</span>, or any valid image file. Max size: <span class="font-semibold text-gray-700 dark:text-gray-200">2MB</span>.
                            </p>
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500" x-show="hasError">
                                @error('image') * {{ $message }} @enderror
                            </span>
                        </div>

                        @if (!empty($service->image))
                            <div class="mt-3">
                                <p class="text-sm text-gray-700 dark:text-white mb-1">Current Image:</p>
                                <img src="{{ getWhyUsListImagePath($service) }}" alt="Current Image" class="h-24 rounded border">
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="flex items-center gap-2 h-[42px] px-4 py-2.5 rounded-lg border border-blue-500 bg-blue-600 text-white font-medium transition-all hover:bg-blue-700 hover:border-blue-600 focus:ring focus:ring-blue-300 dark:bg-blue-700 dark:border-blue-600 dark:hover:bg-blue-800">
                            Update Feature
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
    </script>
    <script>
        function slugGenerator(initialTitle = '', initialSlug = '') {
            return {
                title: initialTitle || '',
                slug: initialSlug || '',

                updateSlug() {
                    if (this.title.length > 0) {
                        fetch("{{ route('be.our-service-list.generate.slug') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ title: this.title })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.slug = data.slug;
                        })
                        .catch(error => console.error('Slug generation error:', error));
                    } else {
                        this.slug = "";
                    }
                }
            };
        }
    </script>
@endsection
