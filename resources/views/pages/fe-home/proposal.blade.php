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
                    Proposal Section
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Enter the main title and description that will appear at the top of the Proposal section. This content should clearly outline the purpose and key highlights of your proposal to engage your audience effectively.
                </p>
            </div>

            <!-- Shortcut Button -->
            <div>
                <a href="{{ route('be.proposal.index') }}"
                   class="inline-flex items-center flex-nowrap gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors whitespace-nowrap">
                    <i class='bx bx-cog text-lg'></i>
                    Manage Proposals
                </a>
            </div>
        </div>

        <!-- Hero Section Form -->
        <div class="border-gray-100 p-5 dark:border-gray-800 sm:p-6">
            <div class="rounded-2xl px-6 pb-8 pt-4 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <form action="{{ route('be.home.proposal.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $content = json_decode($proposal->content ?? '{}', true);
                    @endphp

                    <!-- Proposal Title -->
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
                            <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800 @error('content.description') border-2 border-red-500 @else border-gray-200 dark:border-gray-700 @enderror">
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

                    <!-- Proposal Subtitle -->
                    <div class="mb-4">
                        <!-- Label -->
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Subtitle <span class="text-error-500">*</span>
                        </label>

                        <!-- Editor Container -->
                        <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 mt-2">

                            <!-- Toolbar -->
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
                                <div class="flex flex-wrap items-center">
                                    <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">

                                        <!-- Start Text Color -->
                                        <button
                                            id="toggleTextColorButtonSubtitle"
                                            data-dropdown-toggle="textColorDropdownSubtitle"
                                            type="button"
                                            data-tooltip-target="tooltip-text-color-subtitle"
                                            class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
                                        >
                                            <img src="{{ asset('assets/icons/tiptap/textcolor.svg') }}" alt="">
                                            <span class="sr-only">Text color</span>
                                        </button>
                                        <div
                                            id="tooltip-text-color-subtitle"
                                            role="tooltip"
                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700"
                                        >
                                            Text color
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>

                                        <!-- Color Picker and Color Buttons -->
                                        <div
                                            id="textColorDropdownSubtitle"
                                            class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700"
                                        >
                                            <!-- Color Picker -->
                                            <div class="grid grid-cols-6 gap-2 group mb-3 items-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input type="color" id="colorSubtitle" value="#e66465" class="border-gray-200 border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 rounded-md p-px px-1 hover:bg-gray-50 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 w-full h-8 col-span-3" />
                                                <label for="colorSubtitle" class="text-gray-500 dark:text-gray-400 text-sm font-medium col-span-3 group-hover:text-gray-900 dark:group-hover:text-white">Pick a color</label>
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
                                                id="reset-color-subtitle"
                                                class="py-1.5 text-sm font-medium text-gray-500 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-white w-full dark:hover:bg-gray-600"
                                            >
                                                Reset color
                                            </button>
                                        </div>
                                        <!-- End Text Color -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Toolbar -->

                            <!-- Start Editable Text Area -->
                            <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800 @error('content.subtitle') border-2 border-red-500 @else border-gray-200 dark:border-gray-700 @enderror">
                                <label class="sr-only">Write comment</label>
                                <div id="wysiwyg-subtitle"
                                     class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"></div>
                            </div>
                            <!-- End Editable Text Area -->

                            <!-- Hidden textarea to hold HTML content -->
                            <textarea name="content[subtitle]" id="hiddenSubtitle" class="hidden">{{ old('content.subtitle', $content['subtitle'] ?? '') }}</textarea>
                        </div>

                        <!-- Error message -->
                        @error('content.subtitle')
                        <span class="text-xs mt-1 font-medium text-red-500 dark:text-red-500">
                            * {{ $message }}
                        </span>
                        @enderror
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script type="module">
        import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
        import TextStyle from 'https://esm.sh/@tiptap/extension-text-style@2.6.6';
        import { Color } from 'https://esm.sh/@tiptap/extension-color@2.6.6';

        const editorsData = [
            { editorElementId: 'wysiwyg-title', hiddenTextareaId: 'hiddenTitle', suffix: 'Title' },
            { editorElementId: 'wysiwyg-subtitle', hiddenTextareaId: 'hiddenSubtitle', suffix: 'Subtitle' },
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
                            color: false
                        }),
                        TextStyle,
                        Color,
                    ],
                    editorProps: {
                        attributes: { class: 'focus:outline-none' },
                    },
                });

                hiddenTextarea.value = editor.getHTML();
                editor.on('update', () => {
                    hiddenTextarea.value = editor.getHTML();
                });

                editors.push({ editor, hiddenTextarea, editorElement });

                editorElement.addEventListener('focus', () => {
                    activeEditor = editor;
                });

                // Color picker input
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

                // Reset color button
                const resetColorBtn = document.getElementById(`reset-color-${suffix.toLowerCase()}`);
                if (resetColorBtn) {
                    resetColorBtn.addEventListener('click', () => {
                        editor.chain().focus().unsetColor().run();
                    });
                }
            });

            // On form submit, update hidden textareas
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
