<?php

declare(strict_types=1);

return [
    /**
     * --------------------------------------------------------------------------
     * Toolbar Default Configuration
     * --------------------------------------------------------------------------
     * Define the default toolbar buttons and groups. Use `|` to separate groups,
     * `~` to insert a flexible spacer between button sets and `[...]` to create dropdowns.
     */
    'toolbar' => '[paragraph heading-1 heading-2 heading-3 heading-4 heading-5 heading-6] | bold italic underline strike | [alignLeft alignCenter alignRight] | bulletList orderedList | subscript superscript | blockquote code highlight hardBreak horizontalRule |  link unlink ~ undo redo',

    /**
     * --------------------------------------------------------------------------
     * Default Tailwind Classes Toggle
     * --------------------------------------------------------------------------
     * Set to `false` to disable all default Tailwind classes and apply your
     * own styling via the fallback CSS class names.
     */
    'use_default_classes' => true,

    /**
     * --------------------------------------------------------------------------
     * Component CSS Classes
     * --------------------------------------------------------------------------
     * Override any of these class strings to customize styling. When
     * `use_default_classes` is `false`, the fallback keys (shown here)
     * are still applied so you can target elements in your own CSS.
     */
    'classes' => [
        'livewire-tiptap-wrapper' => 'w-full border border-zinc-200 rounded-lg outline-none disabled:cursor-not-allowed focus-within:outline-none overflow-hidden focus-within:border-sky-400',
        'livewire-tiptap-editor' => 'text-zinc-700 ps-3 pe-3 py-2 focus:!outline-none',
        'livewire-tiptap-toolbar-parent' => 'border-b border-zinc-200 no-scrollbar',
        'livewire-tiptap-toolbar' => 'flex gap-1 p-1 items-center',
        'livewire-tiptap-toolbar-border' => 'h-4 border-0 bg-zinc-200 w-px mx-1',
        'livewire-tiptap-toolbar-spacer' => 'flex-1',
        'livewire-tiptap-toolbar-button' => 'flex items-center p-1.5 font-medium text-center transition rounded outline-none cursor-pointer text-zinc-500 focus:outline-none hover:text-sky-500 hover:bg-sky-100 [&_svg]:size-5',
        'livewire-tiptap-toolbar-button-active' => 'bg-sky-100 !text-sky-500 [&_svg]:!text-sky-400',
        'livewire-tiptap-toolbar-dropdown-wrapper' => 'flex justify-center',
        'livewire-tiptap-toolbar-dropdown' => 'relative',
        'livewire-tiptap-toolbar-dropdown-menu' => 'absolute left-0 min-w-42 rounded-lg shadow-sm origin-top-left bg-white p-1 outline-none border border-zinc-200 z-[999]',
        'livewire-tiptap-toolbar-dropdown-button' => 'flex items-center gap-3 p-1.5 font-medium text-center transition rounded outline-none cursor-pointer text-zinc-500 focus:outline-none hover:text-sky-500 hover:bg-sky-100 w-full [&_svg]:size-5 [&_svg]:text-zinc-500 hover:[&_svg]:!text-sky-400',
        'livewire-tiptap-toolbar-dropdown-button-active' => 'bg-sky-100 !text-sky-500 [&_svg]:!text-sky-400',
    ],

    /**
     * --------------------------------------------------------------------------
     * Button Mappings
     * --------------------------------------------------------------------------
     * Map each button token to a Blade component alias. By default, Tabler
     * Icons are used. To override, publish the config and set your own:
     *  - Heroicon:       'italic' => 'heroicon-solid-italic'
     *  - Custom SVG:     'strikethrough' => 'livewire-tiptap::icons.strikethrough'
     *  - External view:  'example' => 'vendor.package::icons.example'
     */
    'buttons' => [
        'paragraph' => [
            'icon' => 'tabler-letter-t',
        ],
        'heading-1' => [
            'icon' => 'tabler-h-1',
        ],
        'heading-2' => [
            'icon' => 'tabler-h-2',
        ],
        'heading-3' => [
            'icon' => 'tabler-h-3',
        ],
        'heading-4' => [
            'icon' => 'tabler-h-4',
        ],
        'heading-5' => [
            'icon' => 'tabler-h-5',
        ],
        'heading-6' => [
            'icon' => 'tabler-h-6',
        ],
        'bold' => [
            'icon' => 'tabler-bold',
        ],
        'italic' => [
            'icon' => 'tabler-italic',
        ],
        'strike' => [
            'icon' => 'tabler-strikethrough',
        ],
        'underline' => [
            'icon' => 'tabler-underline',
        ],
        'subscript' => [
            'icon' => 'tabler-subscript',
        ],
        'superscript' => [
            'icon' => 'tabler-superscript',
        ],
        'link' => [
            'icon' => 'tabler-link',
        ],
        'unlink' => [
            'icon' => 'tabler-link-off',
        ],
        'blockquote' => [
            'icon' => 'tabler-blockquote',
        ],
        'code' => [
            'icon' => 'tabler-code',
        ],
        'highlight' => [
            'icon' => 'tabler-highlight',
        ],
        'undo' => [
            'icon' => 'tabler-arrow-back-up',
        ],
        'redo' => [
            'icon' => 'tabler-arrow-forward-up',
        ],
        'bulletList' => [
            'icon' => 'tabler-list',
        ],
        'orderedList' => [
            'icon' => 'tabler-list-numbers',
        ],
        'horizontalRule' => [
            'icon' => 'tabler-minus',
        ],
        'hardBreak' => [
            'icon' => 'tabler-page-break',
        ],
        'alignLeft' => [
            'icon' => 'tabler-align-left',
            'showLabel' => false
        ],
        'alignCenter' => [
            'icon' => 'tabler-align-center',
            'label' => 'customAlignLabelCenter',
        ],
        'alignRight' => [
            'icon' => 'tabler-align-right',
        ]
    ],

    /**
     * --------------------------------------------------------------------------
     * Tiptap Extensions Config
     * --------------------------------------------------------------------------
     * Default settings for Tiptap extensions. Override via the `:extensions`
     * attribute on the Blade component or by publishing this config.
     */
    'extensions' => [
        'link' => [
            // Recognized URL protocols
            'protocols' => ['http', 'https'],
            // Auto-link as you type
            'autolink' => true,
            // Automatically convert pasted URLs to links
            'linkOnPaste' => true,
            // Should links open in a new tab on click?
            'openOnClick' => false,
            // Default protocol if none is specified in the URL
            'defaultProtocol' => 'https',
            // HTML attributes applied to <a> tags
            'HTMLAttributes' => [
                'rel' => 'noopener noreferrer ugc',
                'target' => '_blank',
            ],
            // Custom URL validation callback (JS function string) or null
            'isAllowedUri' => "(url) => url.startsWith('https://')",
            // Conditional auto-linking callback (JS function string) or null
            'shouldAutoLink' => "(url) => url.startsWith('https://')",
            // Deprecated validate option (optional)
            'validate' => null,
        ],
        'emoji' => [
            'enableEmoticons' => true,
        ],
        'textAlign' => [
            'types' => ['heading', 'paragraph'],
        ],
    ],
];
