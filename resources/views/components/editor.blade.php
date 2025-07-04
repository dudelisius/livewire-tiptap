@php
    $wireModel = $attributes->wire('model')->value();
    $mods = $attributes->wire('model')->modifiers()->toArray();

    $entangle = in_array('live', $mods, true)
        ? '$wire.entangle("' . $wireModel . '").live'
        : '$wire.entangle("' . $wireModel . '")';
@endphp

<div
    x-data="livewireTiptap({{ $entangle }}, $wire, @js($extensionsJsLiteral))"
    wire:ignore
    class="{{ $classes['wrapper'] }}"
>
    <div class="{{ $classes['toolbar-parent'] }}">
        <div id="livewire-tiptap-toolbar" class="{{ $classes['toolbar'] }}">
            @foreach ($toolbarButtons as $button)
                @if ($button['type'] === 'dropdown')
                    <x-livewire-tiptap::dropdown :$button :$classes/>
                @elseif ($button['type'] === 'separator')
                    <div class="{{ $classes['toolbar-border'] }}"></div>
                @elseif ($button['type'] === 'spacer')
                    <div class="{{ $classes['toolbar-spacer'] }}"></div>
                @else
                    <x-livewire-tiptap::button :$button :$classes/>
                @endif
            @endforeach
        </div>
    </div>
    <div x-ref="livewireTiptapEditor" class="{{ $classes['editor'] }}"></div>
</div>
