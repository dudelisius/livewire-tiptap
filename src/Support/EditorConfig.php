<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Support;

use Illuminate\Support\Facades\Lang;

final class EditorConfig
{
    /** @var array<int, array<string, mixed>> */
    public array $buttons;

    /** @var array<string, mixed> */
    public array $extensionsConfig;

    public string $extensionsJsLiteral;

    /** @var array<string, string> */
    public array $classes;

    public function __construct(?string $toolbar = null, array $extensions = [])
    {
        $rawToolbar = $this->getToolbarConfig($toolbar);
        $this->buttons = $this->parseToolbarButtons($rawToolbar);

        $this->extensionsConfig = $this->getExtensionsConfig($extensions);
        $this->extensionsJsLiteral = base64_encode($this->toJsObjectLiteral($this->extensionsConfig));

        $this->classes = config('livewire-tiptap.classes', []);
    }

    public function getToolbarConfig(?string $override): string
    {
        $default = (string) config('livewire-tiptap.toolbar');

        return trim($override ?: $default);
    }

    public function getExtensionsConfig(?array $override): array
    {
        $defaults = config('livewire-tiptap.extensions', []);

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

        $labelText = $this->resolveLabel($token);
        $tooltip = $this->resolveTooltip($token, $labelText);

        $button = [
            'type' => 'button',
            'token' => $token,
            'action' => $action,
            'active' => $name,
            'options' => $options,
            'icon-component' => config('livewire-tiptap.icons')
                ? config('livewire-tiptap.buttons.' . $token . '.icon', 'tabler-' . $token)
                : false,
            'label' => config('livewire-tiptap.labels')
                ? $labelText
                : false,
            'tooltip' => $tooltip,
        ];

        return $button;
    }

    private function resolveLabel(string $token): string
    {
        $labelKey = 'livewire-tiptap::buttons.' . $token . '.label';

        if (Lang::has($labelKey)) {
            $label = __($labelKey);

            return is_string($label) ? $label : $token;
        }

        $fallbackKey = 'livewire-tiptap::buttons.' . $token;

        if (Lang::has($fallbackKey)) {
            $label = __($fallbackKey);

            return is_string($label) ? $label : $token;
        }

        return $token;
    }

    /** @return array{cmd:string,ctrl:string}|false */
    private function resolveTooltip(string $token, string $label): array|false
    {
        if (! (bool) config('livewire-tiptap.tooltips', true)) {
            return false;
        }

        if (config('livewire-tiptap.buttons.' . $token . '.tooltip') === false) {
            return false;
        }

        $tooltipKey = 'livewire-tiptap::buttons.' . $token . '.tooltip';

        if (Lang::has($tooltipKey)) {
            $translation = __($tooltipKey);

            if (is_array($translation)
                && array_key_exists('cmd', $translation)
                && array_key_exists('ctrl', $translation)
                && is_string($translation['cmd'])
                && is_string($translation['ctrl'])
            ) {
                return ['cmd' => $translation['cmd'], 'ctrl' => $translation['ctrl']];
            }

            if (is_string($translation)) {
                return ['cmd' => $translation, 'ctrl' => $translation];
            }
        }

        return ['cmd' => $label, 'ctrl' => $label];
    }
}
