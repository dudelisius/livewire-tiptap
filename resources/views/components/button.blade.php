@props([
  'button' => null,
])

<button
    type="button"
    {{ $attributes->except('class') }}
    @if (isset($button['action']) && isset($button['options']))
        @click="{{ $button['action'] }}({{ json_encode($button['options']) }})"
    @endif
    @if (isset($button['active']))
        x-bind:class="{ 'livewire-tiptap-toolbar-button-active' : isActive('{{ $button['active'] }}', @js($button['options']), updatedAt) }"
    @endif
    @if ($button['tooltip'])
        {{-- x-tooltip="{{ $button['tooltip']['cmd'] }}" --}}
        x-tooltip="Test"
    @endif
    class="livewire-tiptap-toolbar-button"
>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        @if (isset($button['icon-component']))
            <x-dynamic-component :component="$button['icon-component']" class="shrink-0" />
        @endif

        @if (isset($button['label']))
            {{ $button['label'] }}
        @endif
    @endif
</button>
