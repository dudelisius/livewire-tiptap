<?php

declare(strict_types=1);

namespace Dudelisius\LivewireTiptap;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('livewireTiptapStyles', function () {
            return "<?php echo '<link rel=\"stylesheet\" href=\"' . asset('vendor/livewire-tiptap/css/editor.css') . '\">'; ?>";
        });

        Blade::directive('livewireTiptapScripts', function () {
            return "<?php echo '<script src=\"' . asset('vendor/livewire-tiptap/js/editor.js') . '\"></script>'; ?>";
        });

        Blade::componentNamespace(
            'Dudelisius\\LivewireTiptap\\View\\Components',
            'livewire-tiptap'
        );
    }
}
