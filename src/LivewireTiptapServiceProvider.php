<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap;

use Dudelisius\LivewireTiptap\Livewire\Tiptap;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Override;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/** @psalm-suppress UnusedClass */
class LivewireTiptapServiceProvider extends PackageServiceProvider
{
    #[Override]
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-tiptap')
            ->hasConfigFile()
            ->hasViews();
    }

    #[Override]
    public function bootingPackage(): void
    {
        Blade::directive('livewireTiptapScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/livewire-tiptap/livewire-tiptap.js') . '\"></script>'; ?>";
        });

        Blade::component('livewire-tiptap::components.tiptap', 'livewire-tiptap');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../dist' => public_path('vendor/livewire-tiptap'),
            ], 'livewire-tiptap-assets');
        }

        $this->app->booted(function (): void {
            if (! $this->app->bound('livewire.finder')) {
                return;
            }

            Livewire::component('tiptap', Tiptap::class);
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-tiptap');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'livewire-tiptap');

        $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang/vendor/livewire-tiptap')], 'livewire-tiptap-translations');
    }
}
