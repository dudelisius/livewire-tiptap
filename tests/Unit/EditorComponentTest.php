<?php

declare(strict_types=1);

use Dudelisius\LivewireTiptap\View\Components\Editor;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('livewire-tiptap.toolbar', 'a | b ~ c');
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
    ]);
});

it('gets correct toolbar config when override provided', function () {
    $editor = new Editor('x y');
    $ref = new ReflectionClass(Editor::class);
    $method = $ref->getMethod('getToolbarConfig');
    $method->setAccessible(true);

    expect($method->invoke($editor, 'test'))->toBe('test');
    expect($method->invoke($editor, null))->toBe('a | b ~ c');
});

it('gets correct extensions config merging defaults and override', function () {
    $override = ['link' => ['defaultProtocol' => 'ftp']];
    $editor = new Editor(null, $override);
    $ext = $editor->extensionsConfig['link'];

    expect($ext['openOnClick'])->toBeFalse();
    expect($ext['defaultProtocol'])->toBe('ftp');
});

it('parseToolbarButtons maps separators and spacers and buttons', function () {
    $editor = new Editor('x | y ~');
    $buttons = $editor->toolbarButtons;

    expect($buttons[0])->toMatchArray(['type' => 'button', 'action' => 'toggleX', 'icon' => 'x', 'active' => 'x', 'option' => []]);
    expect($buttons[1])->toMatchArray(['type' => 'separator']);
    expect($buttons[2])->toMatchArray(['type' => 'button', 'action' => 'toggleY', 'icon' => 'y', 'active' => 'y', 'option' => []]);
    expect($buttons[3])->toMatchArray(['type' => 'spacer']);
});

it('toJsObjectLiteral handles primitives, arrays and functions', function () {
    $editor = new Editor;
    $method = (new ReflectionClass(Editor::class))->getMethod('toJsObjectLiteral');
    $method->setAccessible(true);

    expect($method->invoke($editor, 123))->toBe('123');
    expect($method->invoke($editor, ['a', 'b']))->toBe('["a","b"]');
    $fn = '(v) => v+1';
    expect($method->invoke($editor, $fn))->toBe($fn);
});

it('getExtensionsConfig returns defaults when override empty', function () {
    $editor = new Editor(null, []);
    $defaults = Config::get('livewire-tiptap.extensions');

    expect($editor->extensionsConfig)->toEqual($defaults);
});

it('buildProperty maps keys to camelCaseClass', function () {
    $editor = new Editor;
    $method = (new ReflectionClass(Editor::class))->getMethod('buildProperty');
    $method->setAccessible(true);

    expect($method->invoke($editor, 'livewire-tiptap-wrapper'))->toBe('wrapperClass');
    expect($method->invoke($editor, 'livewire-tiptap-toolbar-button-active'))->toBe('toolbarButtonActiveClass');
});

it('compileClasses applies config and fallbacks properly', function () {
    $e1 = new Editor;
    expect($e1->wrapperClass)->toBe('wrap');
    expect($e1->editorClass)->toBe('edit');

    Config::set('livewire-tiptap.use_default_classes', false);
    $e2 = new Editor;
    expect($e2->wrapperClass)->toBe('livewire-tiptap-wrapper');
    expect($e2->toolbarButtonClass)->toBe('livewire-tiptap-toolbar-button');

    Config::set('livewire-tiptap.use_default_classes', true);
    Config::set('livewire-tiptap.classes', []);
    $e3 = new Editor;
    expect($e3->editorClass)->toBe('livewire-tiptap-editor');
});

it('render returns a view with all expected data', function () {
    $view = (new Editor)->render();
    $data = $view->getData();

    expect($view->name())->toBe('livewire-tiptap::components.editor');
    expect($data)->toHaveKeys([
        'toolbarButtons', 'wrapperClass', 'editorClass',
        'toolbarParentClass', 'toolbarClass', 'toolbarBorderClass',
        'toolbarSpacerClass', 'toolbarButtonClass', 'toolbarButtonActiveClass',
    ]);
});

it('mapTokenToButton handles link, unlink, undo and redo actions', function () {
    $btn1 = (new Editor('link'))->toolbarButtons[0];
    expect($btn1['action'])->toBe('setLink');

    $btn2 = (new Editor('unlink'))->toolbarButtons[0];
    expect($btn2['action'])->toBe('unsetLink');

    $btn3 = (new Editor('undo'))->toolbarButtons[0];
    expect($btn3['action'])->toBe('undo');

    $btn4 = (new Editor('redo'))->toolbarButtons[0];
    expect($btn4['action'])->toBe('redo');
});

it('mapTokenToButton maps heading levels correctly', function () {
    $editor = new Editor('heading-3');
    $btn = $editor->toolbarButtons[0];

    expect($btn['type'])->toBe('button');
    expect($btn['action'])->toBe('toggleHeading');
    expect($btn['icon'])->toBe('h-3');
    expect($btn['active'])->toBe('heading');
    expect($btn['option'])->toEqual(['level' => 3]);
});
