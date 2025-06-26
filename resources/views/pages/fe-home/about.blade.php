@php
    use App\Enums\PermissionEnum;
@endphp

@extends('layouts.app')

@section('content')
<!-- ===== Main Content Start ===== -->
<main>
    <div class="p-4 mx-auto max-w-screen-2xl md:p-6">
        <!-- Header Section -->
        <div class="flex px-6 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    About Section
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Customize your About Section to share your story, vision, and values in a compelling way.
                </p>
            </div>
        </div>

        <!-- Hero Section Form -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.home.about.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $content = json_decode($about->content ?? '{}', true);
                    @endphp

                    <!-- About Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Upload Image
                        </label>
                        <div x-data="{
                                hasError: {{ json_encode(session('errors') && session('errors')->has('content.image')) }},
                                previewUrl: {{ json_encode(getAboutUsImageSection($content) ?? '') }}
                            }">

                            <!-- Preview Image -->
                            <div class="flex justify-center">
                                <div x-show="previewUrl" class="my-2 w-full max-w-2xl aspect-[16/9] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <img
                                        :src="previewUrl"
                                        class="w-full h-full object-cover"
                                        alt="Image Preview"
                                    >
                                </div>
                            </div>

                            <input
                                type="file"
                                id="image"
                                name="content[image]"
                                accept="image/*"
                                @change="let file = $event.target.files[0];
                                        if (file) {
                                            let reader = new FileReader();
                                            reader.onload = (e) => previewUrl = e.target.result;
                                            reader.readAsDataURL(file);
                                        }"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                :class="hasError
                                    ? 'border-red-500 dark:border-red-500 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-500'
                                    : 'border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500'"
                            >
                            <p class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-300" id="image_help">
                                Accepted formats: <span class="font-semibold text-gray-700 dark:text-gray-200">JPG, PNG, SVG</span>, or any valid image file. Max size: <span class="font-semibold text-gray-700 dark:text-gray-200">2MB</span>.
                            </p>

                            <!-- Error Message -->
                            <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                                @error('content.image') * {{ $message }} @enderror
                            </span>
                        </div>
                    </div>

                    <!-- About Title -->
                    <div class="mb-4">
                        <!-- Label -->
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Title <span class="text-error-500">*</span>
                        </label>

                        <!-- Editor Container -->
                        <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mt-2">

                            <!-- Toolbar -->
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex flex-wrap items-center">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">

                                        <!-- Start Text Color -->
                                        <button
                                            id="toggleTextColorButtonTitle"
                                            data-dropdown-toggle="textColorDropdownTitle"
                                            type="button"
                                            data-tooltip-target="tooltip-text-color-title"
                                            class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <img src="{{ asset('assets/icons/tiptap/textcolor.svg') }}" alt="">
                                            <span class="sr-only">Text color</span>
                                        </button>
                                        <div
                                            id="tooltip-text-color-title"
                                            role="tooltip"
                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700"
                                        >
                                            Text color
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <!-- Start Color Picker and Color Buttons -->
                                        <div
                                            id="textColorDropdownTitle"
                                            class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700"
                                        >
                                            <!-- Color Picker -->
                                            <div class="grid grid-cols-6 gap-2 group mb-3 items-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input type="color" id="colorTitle" value="#e66465" class="border-gray-200 border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 rounded-md p-px px-1 hover:bg-gray-50 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 w-full h-8 col-span-3" />
                                                <label for="colorTitle" class="text-gray-500 dark:text-gray-400 text-sm font-medium col-span-3 group-hover:text-gray-900 dark:group-hover:text-white">Pick a color</label>
                                            </div>

                                            <!-- Color Buttons -->
                                            <div class="grid grid-cols-6 gap-1 mb-3">
                                                @php
                                                    $colors = [
                                                          ['#05408C', 'Primary'],
                                                          ['#CA5419', 'Secondary'],
                                                          ['#1f2328', 'Base'],
                                                          ['#292D321A', 'Greyscale'],
                                                          ['#9A9A9A', 'Border'],
                                                          ['#FAE8DF', 'Highlight'],
                                                          ['#1A56DB', 'Blue'],
                                                          ['#0E9F6E', 'Green'],
                                                          ['#FACA15', 'Yellow'],
                                                          ['#F05252', 'Red'],
                                                          ['#FF8A4C', 'Orange'],
                                                          ['#0694A2', 'Teal'],
                                                          ['#B4C6FC', 'Light indigo'],
                                                          ['#8DA2FB', 'Indigo'],
                                                          ['#5145CD', 'Purple'],
                                                          ['#771D1D', 'Brown'],
                                                          ['#FCD9BD', 'Light orange'],
                                                          ['#99154B', 'Bordo'],
                                                          ['#7E3AF2', 'Dark Purple'],
                                                          ['#CABFFD', 'Light'],
                                                          ['#D61F69', 'Dark Pink'],
                                                          ['#F8B4D9', 'Pink'],
                                                          ['#F6C196', 'Cream'],
                                                          ['#A4CAFE', 'Light Blue'],
                                                          ['#5145CD', 'Dark Blue'],
                                                          ['#B43403', 'Orange Brown'],
                                                          ['#FCE96A', 'Light Yellow'],
                                                          ['#1E429F', 'Navy Blue'],
                                                          ['#768FFD', 'Light Purple'],
                                                          ['#BCF0DA', 'Light Green'],
                                                          ['#EBF5FF', 'Sky Blue'],
                                                          ['#16BDCA', 'Cyan'],
                                                          ['#E74694', 'Pink'],
                                                          ['#83B0ED', 'Darker Sky Blue'],
                                                          ['#03543F', 'Forest Green'],
                                                          ['#111928', 'Black'],
                                                          ['#4B5563', 'Stone'],
                                                          ['#6B7280', 'Gray'],
                                                          ['#D1D5DB', 'Light Gray'],
                                                          ['#F3F4F6', 'Cloud Gray'],
                                                          ['#F9FAFB', 'Heaven Gray'],
                                                    ];
                                                @endphp

                                                @foreach ($colors as [$hex, $label])
                                                    <button
                                                        type="button"
                                                        data-hex-color="{{ $hex }}"
                                                        style="background-color: {{ $hex }}"
                                                        class="w-6 h-6 rounded-md"
                                                    >
                                                        <span class="sr-only">{{ $label }}</span>
                                                    </button>
                                                @endforeach
                                            </div>

                                            <!-- Reset Color Button -->
                                            <button
                                                type="button"
                                                id="reset-color-title"
                                                class="py-1.5 text-sm font-medium text-gray-500 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-white w-full dark:hover:bg-gray-600"
                                            >
                                                Reset color
                                            </button>
                                        </div>
                                        <!-- End Color Picker and Color Buttons -->

                                        <!-- End Text Color -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Toolbar -->

                            <!-- Start Editable Text Area -->
                            <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800 @error('content.title') border-2 border-red-500 @else border-gray-200 dark:border-gray-700 @enderror">
                                <label class="sr-only">Write comment</label>
                                <div id="wysiwyg-title"
                                     class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></div>
                            </div>
                            <!-- End Editable Text Area -->

                            <!-- Hidden textarea to hold HTML content -->
                            <textarea name="content[title]" id="hiddenTitle" class="hidden">{{ old('content.title', $content['title'] ?? '') }}</textarea>
                        </div>

                        <!-- Error message -->
                        @error('content.title')
                        <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                            * {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <!-- About Description -->
                    <div class="mb-4">
                        <!-- Label -->
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description <span class="text-error-500">*</span>
                        </label>

                        <!-- Editor Container -->
                        <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mt-2">

                            <!-- Toolbar -->
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex flex-wrap items-center">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">

                                        <!-- Start Text Color -->
                                        <button
                                            id="toggleTextColorButtonDescription"
                                            data-dropdown-toggle="textColorDropdownDescription"
                                            type="button"
                                            data-tooltip-target="tooltip-text-color-description"
                                            class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <img src="{{ asset('assets/icons/tiptap/textcolor.svg') }}" alt="">
                                            <span class="sr-only">Text color</span>
                                        </button>
                                        <div
                                            id="tooltip-text-color-description"
                                            role="tooltip"
                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700"
                                        >
                                            Text color
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <!-- Start Color Picker and Color Buttons -->
                                        <div
                                            id="textColorDropdownDescription"
                                            class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700"
                                        >
                                            <!-- Color Picker -->
                                            <div class="grid grid-cols-6 gap-2 group mb-3 items-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input type="color" id="colorDescription" value="#e66465" class="border-gray-200 border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 rounded-md p-px px-1 hover:bg-gray-50 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 w-full h-8 col-span-3" />
                                                <label for="colorDescription" class="text-gray-500 dark:text-gray-400 text-sm font-medium col-span-3 group-hover:text-gray-900 dark:group-hover:text-white">Pick a color</label>
                                            </div>

                                            <!-- Color Buttons -->
                                            <div class="grid grid-cols-6 gap-1 mb-3">
                                                @php
                                                    $colors = [
                                                          ['#05408C', 'Primary'],
                                                          ['#CA5419', 'Secondary'],
                                                          ['#1f2328', 'Base'],
                                                          ['#292D321A', 'Greyscale'],
                                                          ['#9A9A9A', 'Border'],
                                                          ['#FAE8DF', 'Highlight'],
                                                          ['#1A56DB', 'Blue'],
                                                          ['#0E9F6E', 'Green'],
                                                          ['#FACA15', 'Yellow'],
                                                          ['#F05252', 'Red'],
                                                          ['#FF8A4C', 'Orange'],
                                                          ['#0694A2', 'Teal'],
                                                          ['#B4C6FC', 'Light indigo'],
                                                          ['#8DA2FB', 'Indigo'],
                                                          ['#5145CD', 'Purple'],
                                                          ['#771D1D', 'Brown'],
                                                          ['#FCD9BD', 'Light orange'],
                                                          ['#99154B', 'Bordo'],
                                                          ['#7E3AF2', 'Dark Purple'],
                                                          ['#CABFFD', 'Light'],
                                                          ['#D61F69', 'Dark Pink'],
                                                          ['#F8B4D9', 'Pink'],
                                                          ['#F6C196', 'Cream'],
                                                          ['#A4CAFE', 'Light Blue'],
                                                          ['#5145CD', 'Dark Blue'],
                                                          ['#B43403', 'Orange Brown'],
                                                          ['#FCE96A', 'Light Yellow'],
                                                          ['#1E429F', 'Navy Blue'],
                                                          ['#768FFD', 'Light Purple'],
                                                          ['#BCF0DA', 'Light Green'],
                                                          ['#EBF5FF', 'Sky Blue'],
                                                          ['#16BDCA', 'Cyan'],
                                                          ['#E74694', 'Pink'],
                                                          ['#83B0ED', 'Darker Sky Blue'],
                                                          ['#03543F', 'Forest Green'],
                                                          ['#111928', 'Black'],
                                                          ['#4B5563', 'Stone'],
                                                          ['#6B7280', 'Gray'],
                                                          ['#D1D5DB', 'Light Gray'],
                                                          ['#F3F4F6', 'Cloud Gray'],
                                                          ['#F9FAFB', 'Heaven Gray'],
                                                    ];
                                                @endphp

                                                @foreach ($colors as [$hex, $label])
                                                    <button
                                                        type="button"
                                                        data-hex-color="{{ $hex }}"
                                                        style="background-color: {{ $hex }}"
                                                        class="w-6 h-6 rounded-md"
                                                    >
                                                        <span class="sr-only">{{ $label }}</span>
                                                    </button>
                                                @endforeach
                                            </div>

                                            <!-- Reset Color Button -->
                                            <button
                                                type="button"
                                                id="reset-color-description"
                                                class="py-1.5 text-sm font-medium text-gray-500 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-white w-full dark:hover:bg-gray-600"
                                            >
                                                Reset color
                                            </button>
                                        </div>
                                        <!-- End Color Picker and Color Buttons -->
                                        <!-- End Text Color -->

                                        <!-- Start Align Button -->
                                        <div class="px-1">
                                            <span class="block w-px h-4 bg-gray-300 dark:bg-gray-600"></span>
                                        </div>
                                        <button id="toggleLeftAlignButton" type="button" data-tooltip-target="tooltip-left-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6h8m-8 4h12M6 14h8m-8 4h12"/>
                                            </svg>
                                            <span class="sr-only">Align left</span>
                                        </button>
                                        <div id="tooltip-left-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align left
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleCenterAlignButton" type="button" data-tooltip-target="tooltip-center-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h8M6 10h12M8 14h8M6 18h12"/>
                                            </svg>
                                            <span class="sr-only">Align center</span>
                                        </button>
                                        <div id="tooltip-center-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align center
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleRightAlignButton" type="button" data-tooltip-target="tooltip-right-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6h-8m8 4H6m12 4h-8m8 4H6"/>
                                            </svg>
                                            <span class="sr-only">Align right</span>
                                        </button>
                                        <div id="tooltip-right-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align right
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <button id="toggleJustifyAlignButton" type="button" data-tooltip-target="tooltip-justify-align" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                            </svg>
                                            <span class="sr-only">Align justify</span>
                                        </button>
                                        <div id="tooltip-justify-align" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                                            Align justify
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        <!-- End Align Button -->

                                    </div>
                                </div>
                            </div>
                            <!-- End Toolbar -->

                            <!-- Start Editable Text Area -->
                            <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800 @error('content.description') border-2 border-red-500 @else border-gray-200 dark:border-gray-700 @enderror">
                                <label class="sr-only">Write comment</label>
                                <div id="wysiwyg-description"
                                     class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></div>
                            </div>
                            <!-- End Editable Text Area -->

                            <!-- Hidden textarea to hold HTML content -->
                            <textarea name="content[description]" id="hiddenDescription" class="hidden">{{ old('content.description', $content['description'] ?? '') }}</textarea>
                        </div>

                        <!-- Error message -->
                        @error('content.description')
                        <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                            * {{ $message }}
                        </span>
                        @enderror

                        @php
                            $stats = old('content.stats', $content['stats'] ?? []);
                            $stats = array_pad($stats, 3, ['title' => '', 'value' => '', 'suffix' => '']);
                        @endphp

                        @foreach ($stats as $index => $stat)
                            <!-- Judul Statistik -->
                            <div class="mb-4 mt-4">
                                <label for="stat{{ $index }}_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Judul Statistik {{ $index + 1 }} <span class="text-error-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="content[stats][{{ $index }}][title]"
                                    id="stat{{ $index }}_title"
                                    value="{{ old("content.stats.$index.title", $stat['title'] ?? '') }}"
                                    class="mt-2 block w-full rounded-md border px-3 py-2 text-sm @error("content.stats.$index.title") border-red-500 @else border-gray-300 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Contoh: Projek Selesai"
                                    required
                                />

                                @error("content.stats.$index.title")
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                                    * {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <!-- Nilai dan Suffix -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nilai & Satuan {{ $index + 1 }} <span class="text-error-500">*</span>
                                </label>
                                <div class="mt-2 grid grid-cols-3 gap-4">
                                    <!-- Value -->
                                    <input
                                        type="text"
                                        name="content[stats][{{ $index }}][value]"
                                        value="{{ old("content.stats.$index.value", $stat['value'] ?? '') }}"
                                        class="col-span-2 rounded-md border px-3 py-2 text-sm @error("content.stats.$index.value") border-red-500 @else border-gray-300 @enderror dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Contoh: 250"
                                        required
                                    />

                                    <!-- Suffix -->
                                    <input
                                        type="text"
                                        name="content[stats][{{ $index }}][suffix]"
                                        value="{{ old("content.stats.$index.suffix", $stat['suffix'] ?? '') }}"
                                        class="col-span-1 rounded-md border px-3 py-2 text-sm border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Contoh: %, +, Tahun+"
                                    />
                                </div>

                                @error("content.stats.$index.value")
                                <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                                    * {{ $message }}
                                </span>
                                @enderror
                            </div>
                        @endforeach

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                            Save Changes
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script type="module">
        import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
        import TextStyle from 'https://esm.sh/@tiptap/extension-text-style@2.6.6';
        import { Color } from 'https://esm.sh/@tiptap/extension-color@2.6.6';
        import TextAlign from 'https://esm.sh/@tiptap/extension-text-align@2.6.6';

        const editorsData = [
            { editorElementId: 'wysiwyg-title', hiddenTextareaId: 'hiddenTitle', suffix: 'Title' },
            { editorElementId: 'wysiwyg-description', hiddenTextareaId: 'hiddenDescription', suffix: 'Description' },
        ];

        const editors = [];
        let activeEditor = null;

        window.addEventListener('load', () => {
            editorsData.forEach(({ editorElementId, hiddenTextareaId, suffix }) => {
                const editorElement = document.getElementById(editorElementId);
                const hiddenTextarea = document.getElementById(hiddenTextareaId);
                if (!editorElement || !hiddenTextarea) return;

                const editor = new Editor({
                    element: editorElement,
                    content: hiddenTextarea.value || '',
                    extensions: [
                        StarterKit.configure({
                            textStyle: false,
                            color: false,
                        }),
                        TextStyle,
                        Color,
                        TextAlign.configure({
                            types: ['paragraph'],
                            alignments: ['left', 'center', 'right', 'justify'],
                        }),
                    ],
                    editorProps: {
                        attributes: { class: 'focus:outline-none' },
                    },
                    onFocus() {
                        activeEditor = editor; // ✅ gunakan event onFocus dari tiptap
                    },
                });

                // Sync to hidden textarea
                hiddenTextarea.value = editor.getHTML();
                editor.on('update', () => {
                    hiddenTextarea.value = editor.getHTML();
                });

                editors.push({ editor, hiddenTextarea, editorElement });

                // Warna dari color picker input
                const colorPicker = document.getElementById(`color${suffix}`);
                if (colorPicker) {
                    colorPicker.addEventListener('input', e => {
                        editor.chain().focus().setColor(e.target.value).run();
                    });
                }

                // Predefined color buttons
                document.querySelectorAll(`#textColorDropdown${suffix} [data-hex-color]`).forEach(button => {
                    button.addEventListener('click', () => {
                        editor.chain().focus().setColor(button.getAttribute('data-hex-color')).run();
                    });
                });

                // Reset warna
                const resetColorBtn = document.getElementById(`reset-color-${suffix.toLowerCase()}`);
                if (resetColorBtn) {
                    resetColorBtn.addEventListener('click', () => {
                        editor.chain().focus().unsetColor().run();
                    });
                }
            });

            // ✅ Gunakan hanya activeEditor untuk alignment
            document.getElementById('toggleLeftAlignButton')?.addEventListener('click', () => {
                if (activeEditor) activeEditor.chain().focus().setTextAlign('left').run();
            });
            document.getElementById('toggleCenterAlignButton')?.addEventListener('click', () => {
                if (activeEditor) activeEditor.chain().focus().setTextAlign('center').run();
            });
            document.getElementById('toggleRightAlignButton')?.addEventListener('click', () => {
                if (activeEditor) activeEditor.chain().focus().setTextAlign('right').run();
            });
            document.getElementById('toggleJustifyAlignButton')?.addEventListener('click', () => {
                if (activeEditor) activeEditor.chain().focus().setTextAlign('justify').run();
            });

            // Saat form submit, simpan HTML ke textarea
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', () => {
                    editors.forEach(({ editor, hiddenTextarea }) => {
                        hiddenTextarea.value = editor.getHTML();
                    });
                });
            }
        });
    </script>
@endsection
