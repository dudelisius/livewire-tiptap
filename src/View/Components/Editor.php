<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

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
        $this->extensionsJsLiteral = $this->toJsObjectLiteral($this->extensionsConfig);

        $this->compileClasses();
    }

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

        return $isAssoc ? '{' . $inner . '}' : '[' . $inner . ']';
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
            'label' => config('livewire-tiptap.buttons.' . $token . '.label'),
        ];
    }

    protected function compileClasses(): void
    {
        $useDefault = config('livewire-tiptap.use_default_classes', true);
        $config = config('livewire-tiptap.classes', []);

        $fallbacks = [
            'livewire-tiptap-wrapper',
            'livewire-tiptap-editor',
            'livewire-tiptap-toolbar-parent',
            'livewire-tiptap-toolbar',
            'livewire-tiptap-toolbar-border',
            'livewire-tiptap-toolbar-spacer',
            'livewire-tiptap-toolbar-button',
            'livewire-tiptap-toolbar-button-active',
            'livewire-tiptap-toolbar-dropdown-wrapper',
            'livewire-tiptap-toolbar-dropdown',
            'livewire-tiptap-toolbar-dropdown-button',
            'livewire-tiptap-toolbar-dropdown-button-active',
            'livewire-tiptap-toolbar-dropdown-menu',
            'livewire-tiptap-toolbar-dropdown-button',
            'livewire-tiptap-toolbar-dropdown-button-active',
        ];

        $this->classes = [];

        foreach ($fallbacks as $key) {
            $property = $this->buildProperty($key);
            $val = ($useDefault && ! empty(trim((string) ($config[$key] ?? ''))))
                ? $config[$key]
                : $key;

            $this->classes[$property] = $val;
        }
    }

    protected function buildProperty(string $key): string
    {
        $prop = preg_replace('/^livewire-tiptap-/', '', $key);

        return $prop;
    }
}
