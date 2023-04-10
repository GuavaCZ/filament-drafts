<?php

namespace Guava\FilamentDrafts\Admin\Actions;

use Filament\Pages\Actions\Action;

class PublishAction extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->color('success')
            ->action('publish')
            ->label(__('filament-drafts::actions.publish'))
        ;
    }

}
