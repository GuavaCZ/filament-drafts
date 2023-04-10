<?php

namespace Guava\FilamentDrafts;
use Filament\PluginServiceProvider;
use Guava\FilamentDrafts\Tables\Http\Livewire\DraftableTable;
use Guava\FilamentDrafts\Tables\Http\Livewire\RevisionsPaginator;
use Livewire\Livewire;

class FilamentDraftsServiceProvider extends PluginServiceProvider
{

    public static string $name = 'filament-drafts';

    protected array $styles = [
        'filament-drafts-styles' => __DIR__ . '/../dist/plugin.css',
    ];

    public function packageBooted(): void
    {
        parent::packageBooted();

        Livewire::component('filament-drafts::draftable-table', DraftableTable::class);
        Livewire::component('filament-drafts::revisions-paginator', RevisionsPaginator::class);
    }

}
