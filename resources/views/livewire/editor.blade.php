@props([
    'id' => str()->random(),
    'placeholder' => null,
])

<div
    x-data="livewireTiptap($wire.entangle('value'), '{{ $extensionsJsLiteral }}')"
    @class([
        'livewire-tiptap-wrapper',
        'with-focus' => config('livewire-tiptap.focus_within'),
    ])
>
    <div class="livewire-tiptap-toolbar">
        @foreach ($buttons as $button)
            @if ($button['type'] === 'separator')
                <div class="livewire-tiptap-toolbar-separator"></div>
            @elseif ($button['type'] === 'spacer')
                <div class="livewire-tiptap-toolbar-spacer"></div>
            @elseif ($button['type'] === 'dropdown')
                <x-livewire-tiptap::dropdown :$button/>
            @else
                <x-livewire-tiptap::button :$button/>
            @endif
        @endforeach
        {{ $slot }}
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
