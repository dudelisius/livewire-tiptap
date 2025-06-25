@props([
  'active' => null,
  'option' => [],
  'toolbarButtonClass' => null,
  'toolbarButtonActiveClass' => null,
])

<button
    type="button"
    {{ $attributes->except('class') }}
    @if($active)
        :class="{ '{{ $toolbarButtonActiveClass }}' : isActive('{{ $active }}', @js($option), updatedAt) }"
    @endif
        class="{{ $toolbarButtonClass }}"
>
    <x-dynamic-component :component="$component" class="size-5" stroke-width="1.9" />
</button>
