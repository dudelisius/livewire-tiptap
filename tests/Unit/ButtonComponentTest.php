<?php

declare(strict_types=1);

use Dudelisius\LivewireTiptap\View\Components\Button;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('livewire-tiptap.icons', [
        'bold' => 'tabler-bold',
        'italic' => 'tabler-italic',
    ]);
});

it('initializes public properties correctly', function () {
    $btn = new Button('bold', 'italic', ['level' => 2]);

    expect($btn->icon)->toBe('bold');
    expect($btn->active)->toBe('italic');
    expect($btn->option)->toEqual(['level' => 2]);
});

it('renders the correct view', function () {
    $btn = new Button('bold');
    $view = $btn->render();

    expect($view->name())->toBe('livewire-tiptap::components.button');
});

it('uses config mapping for component alias', function () {
    $btn = new Button('bold');
    $view = $btn->render();
    expect($view->getData()['component'])->toBe('tabler-bold');

    Config::set('livewire-tiptap.icons.bold', 'heroicon-bold');
    $btn2 = new Button('bold');
    $view2 = $btn2->render();
    expect($view2->getData()['component'])->toBe('heroicon-bold');
});

it('falls back to tabler-<icon> when mapping missing', function () {
    Config::set('livewire-tiptap.icons', []);
    $btn = new Button('foo');
    $view = $btn->render();

    expect($view->getData()['component'])->toBe('tabler-foo');
});
