<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Livewire;

use Dudelisius\LivewireTiptap\Support\EditorConfig;
use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Tiptap extends Component
{
    #[Modelable]
    public ?string $value = '';

    public ?string $label = null;
    public ?string $placeholder = null;
    public ?string $error = null;
    public ?string $toolbar = null;

    /** @var array<string, mixed> */
    public array $extensions = [];

    public function render(): View
    {
        $editor = new EditorConfig(toolbar: $this->toolbar, extensions: $this->extensions);

        return view('livewire-tiptap::livewire.editor', [
            'toolbarButtons' => $editor->toolbarButtons,
            'extensionsJsLiteral' => $editor->extensionsJsLiteral,
            'classes' => $editor->classes,
            'label' => $this->label,
            'placeholder' => $this->placeholder,
        ]);
    }
}
