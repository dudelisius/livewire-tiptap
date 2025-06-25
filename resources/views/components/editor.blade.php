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
                    <x-livewire-tiptap::dropdown
                        :toolbarButtonClass="$classes['toolbar-button']"
                        :toolbarButtonActiveClass="$classes['toolbar-button-active']"
                        :icon="$button['icon']"
                        :active="$button['active']"
                        :options="$button['options']"
                    />
                @elseif ($button['type'] === 'separator')
                    <div class="{{ $classes['toolbar-border'] }}"></div>
                @elseif ($button['type'] === 'spacer')
                    <div class="{{ $classes['toolbar-spacer'] }}"></div>
                @else
                    <x-livewire-tiptap::button
                        :toolbarButtonClass="$classes['toolbar-button']"
                        :toolbarButtonActiveClass="$classes['toolbar-button-active']"
                        @click="{{ $button['action'] }}({{ json_encode($button['option']) }})"
                        :icon="$button['icon']"
                        :active="$button['active']"
                        :option="$button['option']"
                    />
                @endif
            @endforeach
        </div>
    </div>
    <div x-ref="livewireTiptapEditor" class="{{ $classes['editor'] }}"></div>
</div>
