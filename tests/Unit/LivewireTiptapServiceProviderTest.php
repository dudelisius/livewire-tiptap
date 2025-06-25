<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('registers @livewireTiptapStyles directive', function () {
    $directives = Blade::getCustomDirectives();

    expect($directives)->toHaveKey('livewireTiptapStyles');

    $rendered = $directives['livewireTiptapStyles']();
    expect($rendered)->toContain('<link rel="stylesheet"');
    expect($rendered)->toContain("asset('vendor/livewire-tiptap/css/editor.css')");
});

it('registers @livewireTiptapScripts directive', function () {
    $directives = Blade::getCustomDirectives();

    expect($directives)->toHaveKey('livewireTiptapScripts');

    $rendered = $directives['livewireTiptapScripts']();
    expect($rendered)->toContain('<script src="');
    expect($rendered)->toContain("asset('vendor/livewire-tiptap/js/editor.js')");
});

it('binds the correct component namespace', function () {
    $namespaces = Blade::getClassComponentNamespaces();

    expect($namespaces)->toHaveKey('livewire-tiptap')
        ->and($namespaces['livewire-tiptap'])->toBe(
            'Dudelisius\\LivewireTiptap\\View\\Components'
        );
});
