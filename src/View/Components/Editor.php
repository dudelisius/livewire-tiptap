<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Override;

/** @psalm-suppress UnusedClass */
class Editor extends Component
{
    public array $toolbarButtons;
    public array $extensionsConfig;
    public string $extensionsJsLiteral;
    public array $classes;

    public function __construct(?string $toolbar = null, array $extensions = [])
    {
        $rawToolbar = $this->getToolbarConfig($toolbar);
        $this->toolbarButtons = $this->parseToolbarButtons($rawToolbar);

        $this->extensionsConfig = $this->getExtensionsConfig($extensions);
        $this->extensionsJsLiteral = base64_encode(json_encode($this->toJsObjectLiteral($this->extensionsConfig)));

        $this->classes = array_flip(config('livewire-tiptap.classes'));
    }

    #[Override]
    public function render(): View
    {
        /** @var view-string */
        $view = 'livewire-tiptap::components.editor';

        return view($view, [
            'toolbarButtons' => $this->toolbarButtons,
            'extensionsConfig' => $this->extensionsConfig,
            'extensionsJsLiteral' => $this->extensionsJsLiteral,
            'classes' => $this->classes,
        ]);
    }

    protected function getToolbarConfig(?string $override): string
    {
        $default = config('livewire-tiptap.toolbar');

        return trim($override ?: $default);
    }

    protected function getExtensionsConfig(?array $override): array
    {
        $defaults = config('livewire-tiptap.extensions', []);
        $merged = array_replace_recursive($defaults, $override);

        return $merged ?: $defaults;
    }

    protected function toJsObjectLiteral(mixed $value): string
    {
        if (is_string($value) && preg_match('/^\s*(?:\(\s*[^\)]+\)|[A-Za-z_$][A-Za-z0-9_$]*)\s*=>/', $value)) {
            return $value;
        }

        if (! is_array($value)) {
            return json_encode($value);
        }

        $isAssoc = array_keys($value) !== range(0, count($value) - 1);
        $pieces = [];

        foreach ($value as $k => $v) {
            $jsValue = $this->toJsObjectLiteral($v);
            $pieces[] = $isAssoc
                ? json_encode((string) $k) . ':' . $jsValue
                : $jsValue;
        }

        $inner = implode(',', $pieces);

        return $isAssoc
            ? '{' . $inner . '}'
            : '[' . $inner . ']';
    }

    protected function parseToolbarButtons(string $raw): array
    {
        $groups = [];
        $counter = 0;

        $raw = preg_replace_callback('/\[([^\]]+)\]/', function (array $m) use (&$groups, &$counter) {
            $key = "__group{$counter}__";
            $groups[$key] = preg_split('/\s+/', trim($m[1]));
            $counter++;

            return $key;
        }, $raw);

        $tokens = preg_split('/\s+/', $raw, -1, PREG_SPLIT_NO_EMPTY);

        return array_map(function (string $token) use ($groups) {
            if (isset($groups[$token])) {
                $dropdownButton = [
                    ...$this->mapTokenToButton($groups[$token][0]),
                    'type' => 'dropdown',
                    'options' => array_map([$this, 'mapTokenToButton'], $groups[$token]),
                    'active' => $groups[$token][0],
                ];

                unset($dropdownButton['action'], $dropdownButton['label']);

                return $dropdownButton;
            }

            return $this->mapTokenToButton($token);
        }, $tokens);
    }

    protected function mapTokenToButton(string $token): array
    {
        if ($token === '|') {
            return ['type' => 'separator'];
        }

        if ($token === '~') {
            return ['type' => 'spacer'];
        }

        $name = $token;
        $options = [];

        if (preg_match('/^([a-zA-Z]+)-(\d+)$/', $token, $m)) {
            [, $name, $level] = $m;
            $options = ['level' => (int) $level];
        }

        $action = match ($name) {
            'paragraph' => 'setParagraph',
            'link' => 'setLink',
            'unlink' => 'unsetLink',
            'hardBreak' => 'setHardBreak',
            'horizontalRule' => 'setHorizontalRule',
            'leftAlign' => 'setTextAlign("left")',
            'centerAlign' => 'setTextAlign("center")',
            'rightAlign' => 'setTextAlign("right")',
            'undo', 'redo' => $name,
            default => 'toggle' . ucfirst($name),
        };

        return [
            'type' => 'button',
            'token' => $token,
            'action' => $action,
            'icon-component' => config('livewire-tiptap.buttons.' . $token . '.icon', 'tabler-' . $token),
            'active' => $name,
            'options' => $options,
            'label' => 'livewire-tiptap::buttons.' . $token,
        ];
    }
}
