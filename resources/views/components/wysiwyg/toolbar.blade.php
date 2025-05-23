<div class="px-3 py-2 border-b border-gray-200 dark:border-gray-600">
    <div class="flex flex-wrap items-center">
        <div class="flex items-center space-x-1 rtl:space-x-reverse flex-wrap">
            <!-- Start Bold -->
            <button id="toggleBoldButton" data-tooltip-target="tooltip-bold" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <img src="{{ asset('assets/icons/tiptap/bold.svg') }}" alt="">
                <span class="sr-only">Bold</span>
            </button>
            <div id="tooltip-bold" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Toggle bold
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <!-- End Bold -->

            <!-- Start Italic -->
            <button id="toggleItalicButton" data-tooltip-target="tooltip-italic" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <img src="{{ asset('assets/icons/tiptap/italic.svg') }}" alt="">
                <span class="sr-only">Italic</span>
            </button>
            <div id="tooltip-italic" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Toggle italic
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <!-- End Italic -->

            <!-- Start Underline -->
            <button id="toggleUnderlineButton" data-tooltip-target="tooltip-underline" type="button" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <img src="{{ asset('assets/icons/tiptap/underline.svg') }}" alt="">
                <span class="sr-only">Underline</span>
            </button>
            <div id="tooltip-underline" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Toggle underline
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <!-- End Underline -->

            <!-- Start Text Size -->
            <button id="toggleTextSizeButton" data-dropdown-toggle="textSizeDropdown" type="button" data-tooltip-target="tooltip-text-size" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <img src="{{ asset('assets/icons/tiptap/textsize.svg') }}" alt="">
                <span class="sr-only">Text size</span>
            </button>
            <div id="tooltip-text-size" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Text size
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="textSizeDropdown" class="z-10 hidden w-72 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                <ul class="space-y-1 text-sm font-medium" aria-labelledby="toggleTextSizeButton">
                    <li>
                        <button data-text-size="16px" type="button" class="flex justify-between items-center w-full text-base rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">16px (Default)
                        </button>
                    </li>
                    <li>
                        <button data-text-size="12px" type="button" class="flex justify-between items-center w-full text-xs rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">12px (Tiny)
                        </button>
                    </li>
                    <li>
                        <button data-text-size="14px" type="button" class="flex justify-between items-center w-full text-sm rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">14px (Small)
                        </button>
                    </li>
                    <li>
                        <button data-text-size="18px" type="button" class="flex justify-between items-center w-full text-lg rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">18px (Lead)
                        </button>
                    </li>
                    <li>
                        <button data-text-size="24px" type="button" class="flex justify-between items-center w-full text-2xl rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">24px (Large)
                        </button>
                    </li>
                    <li>
                        <button data-text-size="36px" type="button" class="flex justify-between items-center w-full text-4xl rounded-sm px-3 py-2 hover:bg-gray-100 text-gray-900 dark:hover:bg-gray-600 dark:text-white">36px (Huge)
                        </button>
                    </li>
                </ul>
            </div>
            <!-- End Text Size -->

            <!-- Start Text Color -->
            <button id="toggleTextColorButton" data-dropdown-toggle="textColorDropdown" type="button" data-tooltip-target="tooltip-text-color" class="p-1.5 text-gray-500 rounded-sm cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                <img src="{{ asset('assets/icons/tiptap/textcolor.svg') }}" alt="">
                <span class="sr-only">Text color</span>
            </button>
            <div id="tooltip-text-color" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                Text color
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>

            <!-- Start Color Picker and Color Buttons -->
            <div id="textColorDropdown" class="z-10 hidden w-48 rounded-sm bg-white p-2 shadow-sm dark:bg-gray-700">
                <!-- Color Picker -->
                <div class="grid grid-cols-6 gap-2 group mb-3 items-center p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                    <input type="color" id="color" value="#e66465" class="border-gray-200 border bg-gray-50 dark:bg-gray-700 dark:border-gray-600 rounded-md p-px px-1 hover:bg-gray-50 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 w-full h-8 col-span-3" />
                    <label for="color" class="text-gray-500 dark:text-gray-400 text-sm font-medium col-span-3 group-hover:text-gray-900 dark:group-hover:text-white">Pick a color</label>
                </div>

                <!-- Color Buttons -->
                <div class="grid grid-cols-6 gap-1 mb-3">
                    @php
                        $colors = [
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
                <button type="button" id="reset-color" class="py-1.5 text-sm font-medium text-gray-500 focus:outline-none bg-white rounded-lg hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-gray-400 dark:hover:text-white w-full dark:hover:bg-gray-600">Reset color</button>
            </div>
            <!-- End Color Picker and Color Buttons -->

            <!-- End Text Color -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script type="module">
    import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
    import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
    import Highlight from 'https://esm.sh/@tiptap/extension-highlight@2.6.6';
    import Underline from 'https://esm.sh/@tiptap/extension-underline@2.6.6';
    import Subscript from 'https://esm.sh/@tiptap/extension-subscript@2.6.6';
    import Superscript from 'https://esm.sh/@tiptap/extension-superscript@2.6.6';
    import TextStyle from 'https://esm.sh/@tiptap/extension-text-style@2.6.6';
    import FontFamily from 'https://esm.sh/@tiptap/extension-font-family@2.6.6';
    import { Color } from 'https://esm.sh/@tiptap/extension-color@2.6.6';
    import Bold from 'https://esm.sh/@tiptap/extension-bold@2.6.6';
    import Paragraph from 'https://esm.sh/@tiptap/extension-paragraph@2.6.6';

    // Custom Paragraph extension to add class "text-base"
    const CustomParagraph = Paragraph.extend({
        renderHTML({ HTMLAttributes }) {
            return ['p', { ...HTMLAttributes, class: 'text-base md:text-xl font-medium text-brandBase' }, 0];
        },
    });

    // Custom FontSize extension
    const FontSizeTextStyle = TextStyle.extend({
        addAttributes() {
            return {
                fontSize: {
                    default: null,
                    parseHTML: element => element.style.fontSize,
                    renderHTML: attrs => (attrs.fontSize ? { style: `font-size: ${attrs.fontSize}` } : {}),
                },
            };
        },
    });

    // Custom Bold extension to render bold as span with style
    const CustomBold = Bold.extend({
        renderHTML({ HTMLAttributes }) {
            return ['span', { ...HTMLAttributes, style: 'font-weight: bold;' }, 0];
        },
        excludes: '',
    });

    // Data for each editor
    const editorsData = [
        {
            editorElementId: 'wysiwyg-title',
            hiddenTextareaId: 'hiddenTitle',
            initialContent: `{!! addslashes($content['title'] ?? '') !!}`,
        },
        {
            editorElementId: 'wysiwyg-subtitle',
            hiddenTextareaId: 'hiddenSubtitle',
            initialContent: `{!! addslashes($content['subtitle'] ?? '') !!}`,
        },
        {
            editorElementId: 'wysiwyg-description',
            hiddenTextareaId: 'hiddenDescription',
            initialContent: `{!! addslashes($content['description'] ?? '') !!}`,
        },
    ];

    const editors = [];
    let activeEditor = null;

    window.addEventListener('load', () => {
        editorsData.forEach(({ editorElementId, hiddenTextareaId, initialContent }) => {
            const editorElement = document.getElementById(editorElementId);
            const hiddenTextarea = document.getElementById(hiddenTextareaId);

            if (!editorElement || !hiddenTextarea) return;

            const editor = new Editor({
                element: editorElement,
                content: initialContent || '',
                extensions: [
                    StarterKit.configure({
                        paragraph: false,
                        textStyle: false,
                        bold: false,
                        marks: { bold: false },
                    }),
                    CustomParagraph,
                    CustomBold,
                    Highlight,
                    Underline,
                    Subscript,
                    Superscript,
                    //TextStyle,
                    FontSizeTextStyle,
                    Color,
                    FontFamily,
                ],
                editorProps: {
                    attributes: {
                        class: 'format lg:format-lg dark:format-invert focus:outline-none format-blue max-w-none',
                    },
                    handleFocus: () => {
                        activeEditor = editor;
                        return false;
                    },
                },
            });

            // Initialize hidden textarea
            hiddenTextarea.value = editor.getHTML();

            // Sync on update
            editor.on('update', () => {
                hiddenTextarea.value = editor.getHTML();
            });

            editors.push({ editor, hiddenTextarea });
        });

        // Sync all editors on form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', () => {
                editors.forEach(({ editor, hiddenTextarea }) => {
                    hiddenTextarea.value = editor.getHTML();
                });
            });
        }

        // Toolbar buttons working on the currently focused editor (activeEditor)
        const setupToggle = (buttonId, action) => {
            const btn = document.getElementById(buttonId);
            if (!btn) return;
            btn.addEventListener('click', () => {
                if (!activeEditor) return;
                activeEditor.chain().focus()[action]().run();
            });
        };

        [
            ['toggleBoldButton', 'toggleBold'],
            ['toggleItalicButton', 'toggleItalic'],
            ['toggleUnderlineButton', 'toggleUnderline'],
            ['toggleStrikeButton', 'toggleStrike'],
            ['toggleSubscriptButton', 'toggleSubscript'],
            ['toggleSuperscriptButton', 'toggleSuperscript'],
            ['toggleCodeButton', 'toggleCode'],
        ].forEach(([id, action]) => setupToggle(id, action));

        const highlightBtn = document.getElementById('toggleHighlightButton');
        if (highlightBtn) {
            highlightBtn.addEventListener('click', () => {
                if (!activeEditor) return;
                const isActive = activeEditor.isActive('highlight');
                activeEditor.chain().focus().toggleHighlight({ color: isActive ? undefined : '#ffc078' }).run();
            });
        }

        // Dropdown initialization (Flowbite assumed)
        const setupDropdown = (dropdownId, triggerId) => {
            const dropdownEl = document.getElementById(dropdownId);
            const triggerEl = document.getElementById(triggerId);
            if (!dropdownEl || !triggerEl) return null;
            return new Dropdown(dropdownEl, triggerEl);
        };

        const textSizeDropdown = setupDropdown('textSizeDropdown', 'textSizeDropdownTrigger');
        const fontFamilyDropdown = setupDropdown('fontFamilyDropdown', 'fontFamilyDropdownTrigger');

        // Font size handlers
        document.querySelectorAll('[data-text-size]').forEach(button => {
            button.addEventListener('click', () => {
                if (!activeEditor) return;
                const size = button.getAttribute('data-text-size');
                activeEditor.chain().focus().setMark('textStyle', { fontSize: size }).run();
                textSizeDropdown?.hide();
            });
        });

        // Font family handlers
        document.querySelectorAll('[data-font-family]').forEach(button => {
            button.addEventListener('click', () => {
                if (!activeEditor) return;
                const family = button.getAttribute('data-font-family');
                activeEditor.chain().focus().setFontFamily(family).run();
                fontFamilyDropdown?.hide();
            });
        });

        // Color picker input
        const colorPicker = document.getElementById('color');
        if (colorPicker) {
            colorPicker.addEventListener('input', e => {
                if (!activeEditor) return;
                activeEditor.chain().focus().setColor(e.target.value).run();
            });
        }

        // Predefined color buttons
        document.querySelectorAll('[data-hex-color]').forEach(button => {
            button.addEventListener('click', () => {
                if (!activeEditor) return;
                const color = button.getAttribute('data-hex-color');
                activeEditor.chain().focus().setColor(color).run();
            });
        });

        // Reset color button
        const resetColorBtn = document.getElementById('reset-color');
        if (resetColorBtn) {
            resetColorBtn.addEventListener('click', () => {
                if (!activeEditor) return;
                activeEditor.commands.unsetColor();
            });
        }
    });
</script>
