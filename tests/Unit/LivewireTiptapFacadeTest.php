<?php

declare(strict_types=1);

use Dudelisius\LivewireTiptap\Facades\LivewireTiptap as LivewireTiptapFacade;
use Dudelisius\LivewireTiptap\LivewireTiptap;

it('returns the correct facade accessor', function () {
    $method = new ReflectionMethod(LivewireTiptapFacade::class, 'getFacadeAccessor');
    $method->setAccessible(true);

    expect($method->invoke(null))->toBe(LivewireTiptap::class);
});

it('resolves facade root to service instance', function () {
    $instance = LivewireTiptapFacade::getFacadeRoot();

    expect($instance)->toBeInstanceOf(LivewireTiptap::class);
});
