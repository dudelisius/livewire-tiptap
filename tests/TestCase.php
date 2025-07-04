<?php

declare(strict_types=1);

namespace Tests;

use Dudelisius\LivewireTiptap\LivewireTiptapServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Dudelisius\\LivewireTiptap\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireTiptapServiceProvider::class,
        ];
    }
}
