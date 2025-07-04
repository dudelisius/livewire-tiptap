<?php

declare(strict_types=1);

test('it will not use debugging functions')
    ->expect(['dd', 'dump', 'var_dump', 'print_r'])
    ->not->toBeUsed();

test('it will not use env helper in production code')
    ->expect(['env'])
    ->not->toBeUsed()
    ->ignoring('config');

test('ensure no todos are left')
    ->expect(['TODO', 'FIXME', 'XXX'])
    ->not->toBeUsed();

test('livewire components extend base component', function () {
    arch()
        ->expect('Dudelisius\LivewireTiptap\Components')
        ->toExtend('Livewire\Component')
        ->ignoring('Dudelisius\LivewireTiptap\Components\BaseComponent');
});

test('facades extend base facade', function () {
    arch()
        ->expect('Dudelisius\LivewireTiptap\Facades')
        ->toExtend('Illuminate\Support\Facades\Facade');
});
