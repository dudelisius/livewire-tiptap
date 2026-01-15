<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Dudelisius\LivewireTiptap\Support\EditorConfig;

/** @psalm-suppress UnusedClass */
class Tiptap extends Component
{
	#[Modelable]
	public ?string $value = '';

	public ?string $label = null;
	public ?string $placeholder = null;
	public ?string $toolbar = null;

	/** @var array<string, mixed> */
	public array $extensions = [];

	public function render(): View
	{
		$editor = new EditorConfig(toolbar: $this->toolbar, extensions: $this->extensions);

		return view('livewire-tiptap::livewire.tiptap', [
			'toolbarButtons' => $editor->toolbarButtons,
			'extensionsJsLiteral' => $editor->extensionsJsLiteral,
			'classes' => $editor->classes,
			'label' => $this->label,
			'placeholder' => $this->placeholder,
		]);
	}
}
