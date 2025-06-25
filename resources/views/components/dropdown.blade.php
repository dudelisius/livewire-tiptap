@props([
  'icon' => null,
  'active' => null,
  'options' => [],
  'toolbarButtonClass' => null,
  'toolbarButtonActiveClass' => null,
])

<div class="flex justify-center">
    <div
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

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
        class="relative"
    >

        <x-livewire-tiptap::button
            x-ref="button"
            x-on:click="toggle()"
            x-on:aria-expanded="open"
            x-on:aria-controls="$id('dropdown-button')"
            :$toolbarButtonClass
            :$toolbarButtonActiveClass
            :$icon
            :$active
            :option="[]"
        />

        <!-- Panel -->
        <div
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            x-cloak
            style="z-999"
            class="absolute left-0 min-w-48 rounded-lg shadow-sm mt-2 z-10 origin-top-left bg-white p-1.5 outline-none border border-gray-200"
        >
            @foreach ($options as $button)
                <x-livewire-tiptap::button
                    :$toolbarButtonClass
                    :$toolbarButtonActiveClass
                    @click="{{ $button['action'] }}({{ json_encode($button['option']) }})"
                    :icon="$button['icon']"
                    :active="$button['active']"
                    :option="$button['option']"
                />
            @endforeach
        </div>
    </div>
</div>
