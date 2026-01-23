@props([
    'label' => null,
    'placeholder' => null,
    'error' => null,
])

@php
    $name = $attributes->whereStartsWith('wire:model')->first();
    $id = 'livewire-tiptap-' . $this->getId();
    $invalid ??= ($name && $errors->has($name));
@endphp

<div
    class="livewire-tiptap-component"
    @if ($invalid)
        aria-invalid="true"
        data-invalid
    @endif
>
    @if ($label)
        <label class="livewire-tiptap-label" for="{{ $id }}">{{ $label }}</label>
    @endif

    <livewire-tiptap
        {{ $attributes->whereStartsWith('wire:model') }}
        :$id
        :$placeholder
    >
        {{ $slot }}
    </livewire-tiptap>

    @if ($error)
        <div role="alert" aria-live="polite" aria-atomic="true" class="livewire-tiptap-error-message">{{ $error }}</div>
    @endif

    @error ($attributes->wire('model')->value())
        <div role="alert" aria-live="polite" aria-atomic="true" class="livewire-tiptap-error-message">{{ $message }}</div>
    @enderror
</div>
