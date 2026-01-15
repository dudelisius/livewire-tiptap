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
    'toolbar' => '[paragraph heading-1 heading-2 heading-3 heading-4 heading-5 heading-6] | bold italic underline strike | [leftAlign centerAlign rightAlign] | bulletList orderedList | subscript superscript | blockquote code highlight hardBreak horizontalRule | link unlink ~ undo redo',

    /**
     * --------------------------------------------------------------------------
     * Component CSS Classes
     * --------------------------------------------------------------------------
     * Override any of these class strings if you want to prefer your own. But you are already able to style everything through the livewire-tiptat-editor.css file which can be published.
     */
    'classes' => [
        'livewire-tiptap-wrapper',
        'livewire-tiptap-editor',
        'livewire-tiptap-toolbar',
        'livewire-tiptap-toolbar-border',
        'livewire-tiptap-toolbar-spacer',
        'livewire-tiptap-toolbar-button',
        'livewire-tiptap-toolbar-button-icon',
        'livewire-tiptap-toolbar-button-active',
        'livewire-tiptap-toolbar-dropdown',
        'livewire-tiptap-toolbar-dropdown-menu',
        'livewire-tiptap-toolbar-dropdown-button',
        'livewire-tiptap-toolbar-dropdown-button-icon',
        'livewire-tiptap-toolbar-dropdown-button-active'
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
            'tooltip' => 'Strong emphasis',
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
        'leftAlign' => [
            'icon' => 'tabler-align-left',
            // 'showLabel' => false
        ],
        'centerAlign' => [
            'icon' => 'tabler-align-center',
            // 'label' => 'customAlignLabelCenter',
        ],
        'rightAlign' => [
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
            'protocols' => ['http', 'https'],
            'autolink' => true,
            'linkOnPaste' => true,
            'openOnClick' => false,
            'defaultProtocol' => 'https',
            'HTMLAttributes' => [
                'rel' => 'noopener noreferrer ugc',
                'target' => '_blank',
            ],
            'isAllowedUri' => "(url) => url.startsWith('https://')",
            'shouldAutoLink' => "(url) => url.startsWith('https://')",
            'validate' => null,
        ],
        'emoji' => [
            'enableEmoticons' => true,
        ],
        'textAlign' => [
            'types' => ['heading', 'paragraph'],
        ],
        'placeholder' => [
            'showOnlyWhenEditable' => true,
            'showOnlyCurrent' => false,
        ],
    ],
];
