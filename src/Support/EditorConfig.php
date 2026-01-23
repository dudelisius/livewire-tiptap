<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Support;

final class EditorConfig
{
    /** @var array<int, array<string, mixed>> */
    public array $toolbarButtons;

    /** @var array<string, mixed> */
    public array $extensionsConfig;

    public string $extensionsJsLiteral;

    /** @var array<string, string> */
    public array $classes;

    /**
     * @param  array<string, mixed>  $extensions
     */
    public function __construct(?string $toolbar = null, array $extensions = [])
    {
        $rawToolbar = $this->getToolbarConfig($toolbar);
        $this->toolbarButtons = $this->parseToolbarButtons($rawToolbar);

        $this->extensionsConfig = $this->getExtensionsConfig($extensions);
        $this->extensionsJsLiteral = base64_encode($this->toJsObjectLiteral($this->extensionsConfig));

        $this->classes = config('livewire-tiptap.classes', []);
    }

    public function getToolbarConfig(?string $override): string
    {
        $default = (string) config('livewire-tiptap.toolbar');

        return trim($override ?: $default);
    }

    /**
     * @param  array<string, mixed>|null  $override
     * @return array<string, mixed>
     */
    public function getExtensionsConfig(?array $override): array
    {
        /** @var array<string, mixed> $defaults */
        $defaults = config('livewire-tiptap.extensions', []);

        /** @var array<string, mixed> $merged */
        $merged = array_replace_recursive($defaults, $override ?? []);

        return $merged ?: $defaults;
    }

    public function toJsObjectLiteral(mixed $value): string
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

    /** @return array<int, array<string, mixed>> */
    public function parseToolbarButtons(string $raw): array
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

    /** @return array<string, mixed> */
    public function mapTokenToButton(string $token): array
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

        $tooltipConfig = config('livewire-tiptap.buttons.' . $token . '.tooltip');

        $button = [
            'type' => 'button',
            'token' => $token,
            'action' => $action,
            'icon-component' => config('livewire-tiptap.buttons.' . $token . '.icon', 'tabler-' . $token),
            'active' => $name,
            'options' => $options,
            'label' => __('livewire-tiptap::buttons.' . $token . '.label'),
            'tooltip' => $tooltipConfig === false
                ? false
                : __('livewire-tiptap::buttons.' . $token . '.tooltip'),
        ];

        return $button;
    }
}
