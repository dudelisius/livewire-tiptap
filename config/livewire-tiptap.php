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
    'toolbar' => '[paragraph heading-1 heading-2 heading-3 heading-4 heading-5 heading-6] | bold italic underline strike | bulletList orderedList | subscript superscript | code highlight | link unlink ~ undo redo',

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
        'livewire-tiptap-wrapper' => 'w-full border border-zinc-300 rounded-md outline-none bg-transparent disabled:cursor-not-allowed focus-within:outline-none overflow-hidden focus-within:border-blue-400 transition',
        'livewire-tiptap-editor' => 'text-zinc-600 p-3 focus:!outline-none [&_ul]:list-disc [&_ol]:list-decimal [&_ul,&_ol]:list-inside [&_li>p]:inline-block',
        'livewire-tiptap-toolbar-parent' => 'border-b border-zinc-300 no-scrollbar',
        'livewire-tiptap-toolbar' => 'flex gap-1 p-1 items-center',
        'livewire-tiptap-toolbar-border' => 'h-4 border-0 bg-zinc-300 w-px mx-1',
        'livewire-tiptap-toolbar-spacer' => 'flex-1',
        'livewire-tiptap-toolbar-button' => 'flex items-center p-1.5 font-medium text-center transition rounded outline-none cursor-pointer text-zinc-400 focus:outline-none hover:text-blue-500 hover:bg-blue-100 [&_svg]:size-5',
        'livewire-tiptap-toolbar-button-active' => 'bg-blue-100 !text-blue-500 [&_svg]:!text-blue-400',
        'livewire-tiptap-toolbar-dropdown-wrapper' => 'flex justify-center',
        'livewire-tiptap-toolbar-dropdown' => 'relative',
        'livewire-tiptap-toolbar-dropdown-menu' => 'absolute left-0 min-w-42 rounded-lg shadow-sm z-10 origin-top-left bg-white p-1 outline-none border border-zinc-200 z-[999]',
        'livewire-tiptap-toolbar-dropdown-button' => 'flex items-center gap-3 p-1.5 font-medium text-center transition rounded outline-none cursor-pointer text-zinc-500 focus:outline-none hover:text-blue-500 hover:bg-blue-100 w-full [&_svg]:size-5 [&_svg]:text-zinc-400 hover:[&_svg]:!text-blue-400',
        'livewire-tiptap-toolbar-dropdown-button-active' => 'bg-blue-100 !text-blue-500 [&_svg]:!text-blue-400',
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
        'bulletList' => [
            'icon' => 'tabler-list',
        ],
        'orderedList' => [
            'icon' => 'tabler-list-numbers',
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
        'blockquote' => [
            'icon' => 'tabler-quote',
        ],
        'bullet-list' => [
            'icon' => 'tabler-list-bulleted',
        ],
        'ordered-list' => [
            'icon' => 'tabler-list-numbers',
        ],
        'horizontal-rule' => [
            'icon' => 'tabler-minus',
        ],
    ],

    /**
     * --------------------------------------------------------------------------
     * Tiptap Extensions Config
     * --------------------------------------------------------------------------
     * Default settings for Tiptap extensions. Override via the `:extensions`
     * attribute on the Blade component or by publishing this config.
     * See full list of Link options: https://tiptap.dev/docs/extensions/marks/link
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
    ],
];
