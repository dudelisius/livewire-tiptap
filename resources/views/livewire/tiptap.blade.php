@php
    /** @var array<int, array<string, mixed>> $toolbarButtons */
    $toolbarButtons = $toolbarButtons ?? [];
    $extensionsJsLiteral = $extensionsJsLiteral ?? '';
    $label = $label ?? null;
    $placeholder = $placeholder ?? null;

    $id = 'livewire-tiptap-' . $this->getId();
@endphp

<div>
    @if ($label)
        <label class="livewire-tiptap-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div
        x-data="livewireTiptap($wire.entangle('value').live, '{{ $extensionsJsLiteral }}')"
        wire:ignore
        class="livewire-tiptap-wrapper"
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
            x-ref="livewireTiptapEditor"
            id="{{ $id }}"
            class="livewire-tiptap-editor"
            @if ($placeholder)
                data-placeholder="{{ $placeholder }}"
            @endif
        ></div>
    </div>
</div>
