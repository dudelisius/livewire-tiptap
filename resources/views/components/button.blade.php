@props([
  'button' => null,
  'classes' => [],
  'showLabel' => false,
  'toolbarButton' => $classes['toolbar-button'],
  'toolbarButtonActive' => $classes['toolbar-button-active'],
])

@dump($showLabel)

<button
    type="button"
    {{ $attributes->except('class') }}
    @if (isset($button['action']) && isset($button['options']))
        @click="{{ $button['action'] }}({{ json_encode($button['options']) }})"
    @endif
    @if (isset($button['active']))
        x-bind:class="{ '{{ $toolbarButtonActive }}' : isActive('{{ $button['active'] }}', @js($button['options']), updatedAt) }"
    @endif
    class="{{ $toolbarButton }}"
>
    @if ($slot->isNotEmpty())
        {{ $slot }}
    @else
        @if (isset($button['icon-component']))
            <x-dynamic-component :component="$button['icon-component']" class="shrink-0" />
        @endif

        @if (isset($button['label']) && $showLabel)
            {{ __($button['label']) }}
        @endif
    @endif
</button>
