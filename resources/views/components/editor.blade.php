@props(['label' => null, 'placeholder' => null])

@php
    $wireModel = $attributes->wire('model')->value();
    $mods = $attributes->wire('model')->modifiers()->toArray();

    $entangle = in_array('live', $mods, true)
        ? '$wire.entangle("' . $wireModel . '").live'
        : '$wire.entangle("' . $wireModel . '")';

    $id = str($wireModel)->slug()->toString();
@endphp

<div>
    @if ($label)
        <label class="livewire-tiptap-label" :for="$id">{{ $label }}</label>
    @endif

    <div
        x-data="livewireTiptap({{ $entangle }}, $wire, '{{ $extensionsJsLiteral }}')"
        wire:ignore
        @class([
            'livewire-tiptap-wrapper',
            $attributes->get('class'),
        ])
    >
        <div class="livewire-tiptap-toolbar">
            @foreach ($toolbarButtons as $button)
                @if ($button['type'] === 'separator')
                    <div class="livewire-tiptap-toolbar-border"></div>
                @elseif ($button['type'] === 'spacer')
                    <div class="livewire-tiptap-toolbar-spacer"></div>
                @elseif ($button['type'] === 'dropdown')
                    <x-livewire-tiptap::dropdown :$button/>
                @else
                    <x-livewire-tiptap::button :$button/>
                @endif
            @endforeach
        </div>
        <div
            x-ref="livewireTiptapEditor"
            class="livewire-tiptap-editor"
            @if ($placeholder)
                data-placeholder="{{ $placeholder }}"
            @endif
        ></div>
    </div>
</div>
