@props([
  'button' => null,
])

<div x-data="{
        open: false,
        options: @js($button['options']),
        selected: '{{ $button['options'][0]['token'] }}',
        init() {
            this.$watch('updatedAt', (value) => {
                this.updateSelected();
            });
        },
        updateSelected() {
            for (let key in this.options) {
                if (this.isLoaded().isActive(this.options[key]['active'], this.options[key]['options'])) {
                    this.selected = this.options[key]['token']
                }
            }
        },
        toggle() {
            if (this.open) return this.close()
            this.$refs.button.focus()
            this.open = true
        },
        close(focusAfter) {
            if (! this.open) return
            this.open = false
            focusAfter && focusAfter.focus()
        }
    }"
    x-on:keydown.escape.prevent.stop="close($refs.button)"
    x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
    x-id="['dropdown-button']"
    class="livewire-tiptap-toolbar-dropdown"
>
    <x-livewire-tiptap::button
        :$button
        class="livewire-tiptap-toolbar-dropdown-button"
        x-ref="button"
        x-on:click="toggle()"
        x-on:aria-expanded="open"
        x-on:aria-controls="$id('dropdown-button')"
    >
        @foreach ($button['options'] as $buttonIcon)
            <x-dynamic-component x-cloak="{{ (bool) !$loop->first }}" :component="$buttonIcon['icon-component']" x-show="selected === '{{ $buttonIcon['token'] }}'"/>
        @endforeach
        <x-tabler-chevron-down class=""/>
    </x-livewire-tiptap::button>

    <div
        x-ref="panel"
        x-show="open"
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-button')"
        x-cloak
        class="livewire-tiptap-toolbar-dropdown-menu"
    >
        {{-- @foreach ($button['options'] as $button)
            <x-livewire-tiptap::button
                :$button
                :$classes
                :showLabel="$button['showLabel'] ?? false"
                :toolbarButton="livewire-tiptap-toolbar-dropdown-button"
                :toolbarButtonActive="livewire-tiptap-toolbar-dropdown-button-active"
            />
        @endforeach --}}
    </div>
</div>
