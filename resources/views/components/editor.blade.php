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
    class="{{ $wrapperClass }}"
>
    <div class="{{ $toolbarParentClass }}">
        <div id="livewire-tiptap-toolbar" class="{{ $toolbarClass }}">
            @foreach ($toolbarButtons as $button)
                @if($button['type'] === 'dropdown')
                    <div x-data="{
                            open: false,
                            selected: '{{ $button['icon'] }}',
                            isActive(name) { return this.selected === name },
                        }"
                        class="{{ $classes['livewire-tiptap-dropdown'] }}"
                        @click.outside="open = false"
                    >
                        <button
                            @click="open = ! open; selected = selected"
                            class="{{ $classes['livewire-tiptap-dropdown-button'] }}"
                        >
                            <x-dynamic-component :component="'tabler-' . selected" />
                            <svg class="ml-1 size-4"><use xlink:href="#icon-chevron-down" /></svg>
                        </button>
                    </div>
                @elseif ($button['type'] === 'separator')
                    <div class="{{ $toolbarBorderClass }}"></div>
                @elseif ($button['type'] === 'spacer')
                    <div class="{{ $toolbarSpacerClass }}"></div>
                @else
                    <x-livewire-tiptap::button
                        :$toolbarButtonClass
                        :$toolbarButtonActiveClass
                        @click="{{ $button['action'] }}({{ json_encode($button['option']) }})"
                        icon="{{ $button['icon'] }}"
                        active="{{ $button['active'] }}"
                        :option="$button['option']"
                    />
                @endif
            @endforeach
        </div>
    </div>
    <div x-ref="livewireTiptapEditor" class="{{ $editorClass }}"></div>
</div>
