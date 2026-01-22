@props([
    'id',
    'label' => null,
    'placeholder' => null,
    'error' => null,
])

<div
    x-data="livewireTiptap($wire.entangle('value'), '{{ $extensionsJsLiteral }}')"
    @class([
        'livewire-tiptap-wrapper',
        'with-focus' => config('livewire-tiptap.focus_within'),
    ])
>
    <div class="livewire-tiptap-toolbar">
        @foreach ($toolbarButtons as $button)
            @if ($button['type'] === 'separator')
                <div class="livewire-tiptap-toolbar-border"></div>
            @elseif ($button['type'] === 'spacer')
                <div class="livewire-tiptap-toolbar-spacer"></div>
            @elseif ($button['type'] === 'dropdown')
                <x-livewire-tiptap::dropdown :button="$button"/>
            @else
                <x-livewire-tiptap::button :button="$button"/>
            @endif
        @endforeach
    </div>

    <div
        wire:ignore
        x-ref="livewireTiptapEditor"
        id="{{ $id }}"
        class="livewire-tiptap-editor livewire-tiptap-editor-styles"
        @if ($placeholderText = $placeholder ?? __('livewire-tiptap::editor.placeholder'))
            data-placeholder="{{ $placeholderText }}"
        @endif
    ></div>
</div>
