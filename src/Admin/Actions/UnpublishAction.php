<?php

namespace Guava\FilamentDrafts\Admin\Actions;

use Filament\Pages\Actions\Action;

class UnpublishAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'unpublish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color('gray')
            ->visible(fn () => $this->getLivewire()->record->isPublished())
            ->requiresConfirmation()
            ->action($this->unpublish(...))
            ->label(__('filament-drafts::actions.unpublish'));
    }

    public function unpublish(): void
    {
        $record = $this->getLivewire()->record;
        $record::withoutTimestamps(fn () => $record->update(['is_published' => false]));

        $this->getLivewire()->dispatch('updateRevisions', $record->id);
    }
}
