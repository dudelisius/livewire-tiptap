<?php

declare(strict_types=1);

return [
    /**
     * --------------------------------------------------------------------------
     * Toolbar Default Configuration
     * --------------------------------------------------------------------------
     * Define the default toolbar buttons and groups. Use `|` to separate groups
     * and `~` to insert a flexible spacer between button sets.
     */
    // 'toolbar' => 'heading-1 heading-2 heading-3 heading-4 heading-5 heading-6 | bold code highlight italic underline | link unlink ~ undo redo',
    'toolbar' => '[heading-1 heading-2 heading-3 heading-4 heading-5 heading-6] | bold code highlight italic underline | link unlink ~ undo redo',

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
        'livewire-tiptap-wrapper' => 'w-full relative border border-zinc-300 rounded-md outline-none bg-transparent disabled:cursor-not-allowed focus-within:outline-none overflow-hidden focus-within:border-blue-400 transition',
        'livewire-tiptap-editor' => 'text-zinc-500 p-3 focus:!outline-none',
        'livewire-tiptap-toolbar-parent' => 'border-b border-zinc-300',
        'livewire-tiptap-toolbar' => 'flex gap-1 p-1 items-center overflow-x-scroll',
        'livewire-tiptap-toolbar-border' => 'h-4 border-0 bg-zinc-300 w-px mx-1',
        'livewire-tiptap-toolbar-spacer' => 'flex-1',
        'livewire-tiptap-toolbar-button' => 'flex items-center p-1.5 font-medium text-center transition rounded outline-none cursor-pointer bg-justify-center text-zinc-400 focus:outline-none hover:text-blue-500 hover:bg-blue-100',
        'livewire-tiptap-toolbar-button-active' => 'bg-blue-100 !text-blue-500',
        'livewire-tiptap-dropdown' => 'relative',
        'livewire-tiptap-dropdown-button' => 'flex items-center',
        'livewire-tiptap-dropdown-menu' => 'absolute mt-1 bg-white shadow-lg',
        'livewire-tiptap-dropdown-option' => 'flex items-center p-1 hover:bg-gray-100',
        'livewire-tiptap-dropdown-option-active' => 'bg-blue-100 text-blue-600',
    ],

    /**
     * --------------------------------------------------------------------------
     * Icon Mappings
     * --------------------------------------------------------------------------
     * Map each button token to a Blade component alias. By default, Tabler
     * Icons are used. To override, publish the config and set your own:
     *  - Heroicon:       'italic' => 'heroicon-solid-italic'
     *  - Custom SVG:     'strikethrough' => 'livewire-tiptap::icons.strikethrough'
     *  - External view:  'example' => 'vendor.package::icons.example'
     */
    'icons' => [
        'heading-1' => 'tabler-h-1',
        'heading-2' => 'tabler-h-2',
        'heading-3' => 'tabler-h-3',
        'heading-4' => 'tabler-h-4',
        'heading-5' => 'tabler-h-5',
        'heading-6' => 'tabler-h-6',
        'bold' => 'tabler-bold',
        'italic' => 'tabler-italic',
        'underline' => 'tabler-underline',
        'link' => 'tabler-link',
        'unlink' => 'tabler-link-off',
        'code' => 'tabler-code',
        'highlight' => 'tabler-highlight',
        'undo' => 'tabler-arrow-back-up',
        'redo' => 'tabler-arrow-forward-up',
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
