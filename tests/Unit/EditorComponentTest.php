<?php

declare(strict_types=1);

use Dudelisius\LivewireTiptap\Support\EditorConfig;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

beforeEach(function () {
    Config::set('livewire-tiptap.toolbar', 'h-1 h-2 [bold italic underline] | link unlink ~ undo redo');
    Config::set('livewire-tiptap.extensions', ['link' => ['openOnClick' => false]]);
    Config::set('livewire-tiptap.use_default_classes', true);
    Config::set('livewire-tiptap.classes', [
        'livewire-tiptap-wrapper' => 'wrap',
        'livewire-tiptap-editor' => 'edit',
        'livewire-tiptap-toolbar-parent' => 'tp',
        'livewire-tiptap-toolbar' => 'tb',
        'livewire-tiptap-toolbar-border' => 'tb-border',
        'livewire-tiptap-toolbar-spacer' => 'tb-space',
        'livewire-tiptap-toolbar-button' => 'tb-btn',
        'livewire-tiptap-toolbar-button-active' => 'tb-btn-act',
        'livewire-tiptap-toolbar-dropdown-wrapper' => 'dd-wrap',
        'livewire-tiptap-toolbar-dropdown' => 'dd',
        'livewire-tiptap-toolbar-dropdown-button' => 'dd-btn',
        'livewire-tiptap-toolbar-dropdown-button-active' => 'dd-btn-act',
        'livewire-tiptap-toolbar-dropdown-menu' => 'dd-menu',
    ]);
});

it('getToolbarConfig returns override or default', function () {
    $editor = new EditorConfig('x y');

    expect($editor->getToolbarConfig('test'))->toBe('test');
    expect($editor->getToolbarConfig(null))->toBe('h-1 h-2 [bold italic underline] | link unlink ~ undo redo');
});

it('getExtensionsConfig merges defaults and override', function () {
    $override = ['link' => ['defaultProtocol' => 'ftp']];
    $editor = new EditorConfig(null, $override);

    expect($editor->extensionsConfig['link']['openOnClick'])->toBeFalse();
    expect($editor->extensionsConfig['link']['defaultProtocol'])->toBe('ftp');
});

it('toJsObjectLiteral handles values correctly', function () {
    $editor = new EditorConfig;

    expect($editor->toJsObjectLiteral(5))->toBe('5');
    expect($editor->toJsObjectLiteral(['a', 'b']))->toBe('["a","b"]');
    $fn = '(x)=>x';
    expect($editor->toJsObjectLiteral($fn))->toBe($fn);
    expect($editor->toJsObjectLiteral(['k' => 1, 'v' => $fn]))->toContain('"k":1');
});

it('parseToolbarButtons builds mixed buttons and dropdowns', function () {
    $editor = new EditorConfig;
    $buttons = $editor->buttons;

    // first two should be heading buttons
    expect($buttons[0]['type'])->toBe('button');
    expect($buttons[0]['token'])->toBe('h-1');
    expect($buttons[1]['token'])->toBe('h-2');

    // third is dropdown
    expect($buttons[2]['type'])->toBe('dropdown');
    expect($buttons[2]['active'])->toBe('bold');
    expect(is_array($buttons[2]['options']))->toBeTrue();

    // then separator
    expect($buttons[3]['type'])->toBe('separator');

    // last two
    expect($buttons[4]['type'])->toBe('button');
    expect($buttons[4]['action'])->toBe('setLink');
});

it('mapTokenToButton respects token, action, icon-component, active, options', function () {
    Config::set('livewire-tiptap.buttons.h-1.icon', 'custom-icon');

    $btn = (new EditorConfig('h-1'))->buttons[0];

    expect($btn['token'])->toBe('h-1');
    expect($btn['action'])->toBe('toggleH');
    expect($btn['icon-component'])->toBe('custom-icon');
    expect($btn['active'])->toBe('h');
    expect($btn['options'])->toEqual(['level' => 1]);
});

it('disables tooltips when global config is false', function () {
    Config::set('livewire-tiptap.tooltips', false);

    $btn = (new EditorConfig('bold'))->buttons[0];

    expect($btn['tooltip'])->toBeFalse();
});

it('disables tooltip when button config is explicitly false', function () {
    Config::set('livewire-tiptap.tooltips', true);
    Config::set('livewire-tiptap.buttons.bold.tooltip', false);

    $btn = (new EditorConfig('bold'))->buttons[0];

    expect($btn['tooltip'])->toBeFalse();
});

it('keeps tooltip translation array with cmd and ctrl', function () {
    Config::set('livewire-tiptap.tooltips', true);
    Config::set('livewire-tiptap.buttons.bold.tooltip', null);

    $btn = (new EditorConfig('bold'))->buttons[0];

    expect($btn['tooltip'])->toBeArray();
    expect($btn['tooltip'])->toHaveKeys(['cmd', 'ctrl']);
});

it('converts tooltip translation string into cmd/ctrl array', function () {
    Config::set('livewire-tiptap.tooltips', true);

    Lang::addLines([
        'buttons.test.tooltip' => 'Hello',
        'buttons.test.label' => 'Test',
    ], 'en', 'livewire-tiptap');

    $btn = (new EditorConfig('test'))->buttons[0];

    expect($btn['tooltip'])->toEqual(['cmd' => 'Hello', 'ctrl' => 'Hello']);
});

it('falls back to label when tooltip translation is missing', function () {
    Config::set('livewire-tiptap.tooltips', true);

    Lang::addLines([
        'buttons.nokey.label' => 'My Label',
    ], 'en', 'livewire-tiptap');

    $btn = (new EditorConfig('nokey'))->buttons[0];

    expect($btn['tooltip'])->toEqual(['cmd' => 'My Label', 'ctrl' => 'My Label']);
});

dataset('tokenActions', [
    'paragraph' => ['paragraph', 'setParagraph'],
    'link' => ['link', 'setLink'],
    'unlink' => ['unlink', 'unsetLink'],
    'hardBreak' => ['hardBreak', 'setHardBreak'],
    'horizontalRule' => ['horizontalRule', 'setHorizontalRule'],
    'undo' => ['undo', 'undo'],
    'redo' => ['redo', 'redo'],
]);

it('maps tokens to the correct action', function (string $token, string $expectedAction) {
    $editor = new EditorConfig($token);
    $btn = $editor->buttons[0];

    expect($btn['action'])->toBe($expectedAction);
})->with('tokenActions');

it('parseToolbarButtons handles a standalone dropdown group', function () {
    Config::set('livewire-tiptap.toolbar', '[a b c]');
    $editor = new EditorConfig;
    $buttons = $editor->buttons;

    expect(count($buttons))->toBe(1);
    expect($buttons[0]['type'])->toBe('dropdown');
    expect($buttons[0]['options'])->toHaveLength(3);

    // first option in dropdown should be 'a'
    expect($buttons[0]['active'])->toBe('a');
});

it('builds buttons, extensionsJsLiteral, and classes', function () {
    $editor = new EditorConfig;

    expect($editor->buttons)->toBeArray();
    expect($editor->extensionsJsLiteral)->toBeString();
    expect($editor->classes)->toBeArray();
});
