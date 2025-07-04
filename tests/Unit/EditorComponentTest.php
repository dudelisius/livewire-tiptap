<?php

declare(strict_types=1);

use Dudelisius\LivewireTiptap\View\Components\Editor;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('livewire-tiptap.toolbar', 'h-1 h-2 [bold italic underline] | link unlink');
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
        'livewire-tiptap-toolbar-button-active' => 'tb-btn-active',
        'livewire-tiptap-toolbar-dropdown-wrapper' => 'dd-wrap',
        'livewire-tiptap-toolbar-dropdown' => 'dd',
        'livewire-tiptap-toolbar-dropdown-button' => 'dd-btn',
        'livewire-tiptap-toolbar-dropdown-button-active' => 'dd-btn-act',
        'livewire-tiptap-toolbar-dropdown-menu' => 'dd-menu',
    ]);
});

it('getToolbarConfig returns override or default', function () {
    $editor = new Editor('x y');
    $rc = new ReflectionClass(Editor::class);
    $m = $rc->getMethod('getToolbarConfig');
    $m->setAccessible(true);

    expect($m->invoke($editor, 'test'))->toBe('test');
    expect($m->invoke($editor, null))->toBe('h-1 h-2 [bold italic underline] | link unlink');
});

it('getExtensionsConfig merges defaults and override', function () {
    $override = ['link' => ['defaultProtocol' => 'ftp']];
    $editor = new Editor(null, $override);

    expect($editor->extensionsConfig['link']['openOnClick'])->toBeFalse();
    expect($editor->extensionsConfig['link']['defaultProtocol'])->toBe('ftp');
});

it('toJsObjectLiteral handles values correctly', function () {
    $editor = new Editor;
    $m = (new ReflectionClass($editor))
        ->getMethod('toJsObjectLiteral');
    $m->setAccessible(true);

    expect($m->invoke($editor, 5))->toBe('5');
    expect($m->invoke($editor, ['a', 'b']))->toBe('["a","b"]');
    $fn = '(x)=>x';
    expect($m->invoke($editor, $fn))->toBe($fn);
    expect($m->invoke($editor, ['k' => 1, 'v' => $fn]))->toContain('"k":1');
});

it('parseToolbarButtons builds mixed buttons and dropdowns', function () {
    $editor = new Editor;
    $buttons = $editor->toolbarButtons;

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

it('mapTokenToButton respects token, action, icon-component, active, options, label', function () {
    Config::set('livewire-tiptap.buttons.h-1.icon', 'custom-icon');
    Config::set('livewire-tiptap.buttons.h-1.label', 'Heading 1');

    $btn = (new Editor('h-1'))->toolbarButtons[0];

    expect($btn['token'])->toBe('h-1');
    expect($btn['action'])->toBe('toggleH');
    expect($btn['icon-component'])->toBe('custom-icon');
    expect($btn['active'])->toBe('h');
    expect($btn['options'])->toEqual(['level' => 1]);
    expect($btn['label'])->toBe('Heading 1');
});

it('compileClasses populates classes array with property keys', function () {
    $editor = new Editor;
    $cls = $editor->classes;

    expect($cls['wrapper'])->toBe('wrap');
    expect($cls['editor'])->toBe('edit');
    expect($cls['toolbar-dropdown-button-active'])->toBe('dd-btn-act');
});

it('render returns view with toolbarButtons, extensionsConfig, extensionsJsLiteral, and classes', function () {
    $view = (new Editor)->render();
    $data = $view->getData();

    expect($view->name())->toBe('livewire-tiptap::components.editor');
    expect($data)->toHaveKeys([
        'toolbarButtons',
        'extensionsConfig',
        'extensionsJsLiteral',
        'classes',
    ]);
});
