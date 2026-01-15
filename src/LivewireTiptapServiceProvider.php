<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap;

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
            ->hasViews()
            ->hasAssets();
    }

    #[Override]
    public function bootingPackage(): void
    {
        Blade::directive('livewireTiptapScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/livewire-tiptap/js/livewire-tiptap.js') . '\"></script>'; ?>";
        });

        // Livewire component usage: <livewire:tiptap />
        // Defer registration until the app is booted so Livewire bindings exist.
        $this->app->booted(function (): void {
            if (! $this->app->bound('livewire.finder')) {
                return;
            }

            Livewire::component('tiptap', \Dudelisius\LivewireTiptap\Livewire\Tiptap::class);
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-tiptap');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'livewire-tiptap');
        $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang/vendor/livewire-tiptap')], 'livewire-tiptap-translations');
    }
}
