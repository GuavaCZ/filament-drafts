<?php

namespace Guava\FilamentDrafts\Admin\Resources\Pages\Create;

use Filament\Pages\Actions\Action;
use Guava\FilamentDrafts\Admin\Actions\PublishAction;
use Guava\FilamentDrafts\Admin\Actions\SaveDraftAction;
use Illuminate\Database\Eloquent\Model;

/**
 * @method getModel()
 */
trait Draftable
{
    public bool $shouldSaveAsDraft = false;

    protected function handleRecordCreation(array $data): Model
    {
        $model = $this->getModel()::make([
            ...$data,
        ]);

        $model->is_published = !$this->shouldSaveAsDraft;

        $model->withoutRevision()->save();
        return $model;
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->color('success')
            ->label(__('filament-drafts::actions.publish'));
    }

    protected function getCreateAnotherFormAction(): Action {
        return parent::getCreateAnotherFormAction()
            ->label(__('filament-drafts::actions.publish_and_create_another'));
    }

    protected function getFormActions(): array
    {
        return [
            ...array_slice(parent::getFormActions(), 0, 1),
            SaveDraftAction::make(),
            ...array_slice(parent::getFormActions(), 1),
        ];
    }
}
