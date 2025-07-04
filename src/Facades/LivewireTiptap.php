<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Facades;

use Illuminate\Support\Facades\Facade;
use Override;

/**
 * @see \Dudelisius\LivewireTiptap\LivewireTiptap
 *
 * @psalm-suppress UnusedClass
 */
class LivewireTiptap extends Facade
{
    #[Override]
    protected static function getFacadeAccessor(): string
    {
        return \Dudelisius\LivewireTiptap\LivewireTiptap::class;
    }
}
