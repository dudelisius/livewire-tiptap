<?php

declare(strict_types=1);

return [
    'paragraph' => [
        'label' => 'Paragraph',
        'tooltip' => [
            'cmd' => 'Paragraph ⌘⌥0',
            'ctrl' => 'Paragraph ^⌥0',
        ],
    ],
    'heading-1' => [
        'label' => 'Heading 1',
        'tooltip' => [
            'cmd' => 'Heading 1 ⌘⌥1',
            'ctrl' => 'Heading 1 ^⌥1',
        ],
    ],
    'heading-2' => [
        'label' => 'Heading 2',
        'tooltip' => [
            'cmd' => 'Heading 2 ⌘⌥2',
            'ctrl' => 'Heading 2 ^⌥2',
        ],
    ],
    'heading-3' => [
        'label' => 'Heading 3',
        'tooltip' => [
            'cmd' => 'Heading 3 ⌘⌥3',
            'ctrl' => 'Heading 3 ^⌥3',
        ],
    ],
    'heading-4' => [
        'label' => 'Heading 4',
        'tooltip' => [
            'cmd' => 'Heading 4 ⌘⌥4',
            'ctrl' => 'Heading 4 ^⌥4',
        ],
    ],
    'heading-5' => [
        'label' => 'Heading 5',
        'tooltip' => [
            'cmd' => 'Heading 5 ⌘⌥5',
            'ctrl' => 'Heading 5 ^⌥5',
        ],
    ],
    'heading-6' => [
        'label' => 'Heading 6',
        'tooltip' => [
            'cmd' => 'Heading 6 ⌘⌥6',
            'ctrl' => 'Heading 6 ^⌥6',
        ],
    ],

    'blockquote' => [
        'label' => 'Blockquote',
        'tooltip' => [
            'cmd' => 'Blockquote ⌘⇧B',
            'ctrl' => 'Blockquote ^⇧B',
        ],
    ],

    // HorizontalRule heeft geen default shortcut; het is een input rule (--- of ___ ) aan begin van de regel.
    'horizontalRule' => [
        'label' => 'Horizontal rule',
        'tooltip' => [
            'cmd' => 'Horizontal rule: type --- (new line)',
            'ctrl' => 'Horizontal rule: type --- (new line)',
        ],
    ],
    'horizontal-rule' => [
        'label' => 'Horizontal rule',
        'tooltip' => [
            'cmd' => 'Horizontal rule: type --- (new line)',
            'ctrl' => 'Horizontal rule: type --- (new line)',
        ],
    ],

    'bold' => [
        'label' => 'Bold',
        'tooltip' => [
            'cmd' => 'Bold ⌘B',
            'ctrl' => 'Bold ^B',
        ],
    ],
    'italic' => [
        'label' => 'Italic',
        'tooltip' => [
            'cmd' => 'Italic ⌘I',
            'ctrl' => 'Italic ^I',
        ],
    ],
    'underline' => [
        'label' => 'Underline',
        'tooltip' => [
            'cmd' => 'Underline ⌘U',
            'ctrl' => 'Underline ^U',
        ],
    ],

    // FIX: Strikethrough is Shift+S (niet Shift+X)
    'strike' => [
        'label' => 'Strikethrough',
        'tooltip' => [
            'cmd' => 'Strikethrough ⌘⇧S',
            'ctrl' => 'Strikethrough ^⇧S',
        ],
    ],

    'highlight' => [
        'label' => 'Highlight',
        'tooltip' => [
            'cmd' => 'Highlight ⌘⇧H',
            'ctrl' => 'Highlight ^⇧H',
        ],
    ],

    'code' => [
        'label' => 'Code',
        'tooltip' => [
            'cmd' => 'Code ⌘E',
            'ctrl' => 'Code ^E',
        ],
    ],

    'bulletList' => [
        'label' => 'Bullet list',
        'tooltip' => [
            'cmd' => 'Bullet list ⌘⇧8',
            'ctrl' => 'Bullet list ^⇧8',
        ],
    ],
    'orderedList' => [
        'label' => 'Numbered list',
        'tooltip' => [
            'cmd' => 'Numbered list ⌘⇧7',
            'ctrl' => 'Numbered list ^⇧7',
        ],
    ],

    'subscript' => [
        'label' => 'Subscript',
        'tooltip' => [
            'cmd' => 'Subscript ⌘,',
            'ctrl' => 'Subscript ^,',
        ],
    ],
    'superscript' => [
        'label' => 'Superscript',
        'tooltip' => [
            'cmd' => 'Superscript ⌘.',
            'ctrl' => 'Superscript ^.',
        ],
    ],

    // Link: geen default shortcut in de Link extension.
    // Als jij in je app wél Mod-K gebruikt om je link UI te openen, kun je dit laten staan,
    // maar "Tiptap default" is: geen shortcut.
    'link' => [
        'label' => 'Insert link',
        'tooltip' => [
            'cmd' => 'Insert link (no default shortcut)',
            'ctrl' => 'Insert link (no default shortcut)',
        ],
    ],
    'unlink' => [
        'label' => 'Remove link',
    ],

    // Hard break: Shift+Enter (en in veel setups ook Mod+Enter als “line break”)
    'hardBreak' => [
        'label' => 'Hard break',
        'tooltip' => [
            'cmd' => 'Hard break ⇧⏎',
            'ctrl' => 'Hard break ⇧⏎',
        ],
    ],

    'leftAlign' => [
        'label' => 'Align left',
        'tooltip' => [
            'cmd' => 'Align left ⌘⇧L',
            'ctrl' => 'Align left ^⇧L',
        ],
    ],
    'centerAlign' => [
        'label' => 'Align center',
        'tooltip' => [
            'cmd' => 'Align center ⌘⇧E',
            'ctrl' => 'Align center ^⇧E',
        ],
    ],
    'rightAlign' => [
        'label' => 'Align right',
        'tooltip' => [
            'cmd' => 'Align right ⌘⇧R',
            'ctrl' => 'Align right ^⇧R',
        ],
    ],

    'undo' => [
        'label' => 'Undo',
        'tooltip' => [
            'cmd' => 'Undo ⌘Z',
            'ctrl' => 'Undo ^Z',
        ],
    ],
    'redo' => [
        'label' => 'Redo',
        'tooltip' => [
            'cmd' => 'Redo ⌘⇧Z',
            'ctrl' => 'Redo ^⇧Z',
        ],
    ],
];
