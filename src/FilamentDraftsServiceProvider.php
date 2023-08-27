<?php

namespace Guava\FilamentDrafts;

use Guava\FilamentDrafts\Tables\Http\Livewire\DraftableTable;
use Guava\FilamentDrafts\Tables\Http\Livewire\RevisionsPaginator;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;

class FilamentDraftsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-drafts';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasViews(static::$name);
    }

    public function bootingPackage(): void
    {
        parent::bootingPackage();

        FilamentAsset::register([
            Css::make('filament-drafts-styles', __DIR__ . '/../dist/plugin.css'),
        ], package: 'guava/filament-drafts');

        Livewire::component('filament-drafts::revisions-paginator', RevisionsPaginator::class);
    }
}
