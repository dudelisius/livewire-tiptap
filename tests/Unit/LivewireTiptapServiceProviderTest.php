<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('registers @livewireTiptapScripts directive', function () {
    $directives = Blade::getCustomDirectives();

    expect($directives)->toHaveKey('livewireTiptapScripts');

    $rendered = $directives['livewireTiptapScripts']();
    expect($rendered)->toContain('<script src="');
    expect($rendered)->toContain("asset('vendor/livewire-tiptap/js/livewire-tiptap.js')");
});

it('registers the <livewire:tiptap /> component alias', function () {
    expect(app('livewire')->exists('tiptap'))->toBeTrue();
});
