<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public ?string $icon;

    public ?string $active;

    public array $option;

    public function __construct(
        ?string $icon = null,
        ?string $active = null,
        array $option = []
    ) {
        $this->icon = $icon;
        $this->active = $active;
        $this->option = $option;
    }

    public function render(): View
    {
        /** @var view-string */
        $view = 'livewire-tiptap::components.button';

        $component = config(
            'livewire-tiptap.icons.' . $this->icon,
            'tabler-' . $this->icon
        );

        return view($view, compact('component'));
    }
}
