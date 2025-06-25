<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dudelisius\LivewireTiptap\LivewireTiptap
 */
class LivewireTiptap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Dudelisius\LivewireTiptap\LivewireTiptap::class;
    }
}
