<?php

namespace Guava\FilamentDrafts\Admin\Resources\Pages\Edit;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Guava\FilamentDrafts\Admin\Actions\SaveDraftAction;
use Guava\FilamentDrafts\Admin\Actions\UnpublishAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

/**
 *
 * @method Model getRecord()
 * @method string getResource()
 */
trait Draftable
{
    public bool $shouldSaveAsDraft = false;

    public function renderingDraftable(): void
    {
        Filament::registerRenderHook('content.end',
            function () {
                return view('filament-drafts::filament.revisions-paginator', [
                    'resource' => $this->getResource(),
                    'record' => $this->getRecord(),
                ]);
            }
        );
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($record->isPublished() && $this->shouldSaveAsDraft) {
            $record->updateAsDraft($data);
        } else if ($record->isPublished() && !$this->shouldSaveAsDraft) {
            $record->update($data);
        } else if (!$record->is_current && $this->shouldSaveAsDraft) {
            $record->updateAsDraft($data);
        } else {
            // Unpublish all other revisions
            if (!$this->shouldSaveAsDraft) {
                /** @var HasMany $revisions */
                $record::withoutTimestamps(fn() => $record->revisions()
                    ->where('is_published', true)
                    ->update(['is_published' => false]));
            }
            $record->update($data);
            $record->is_published = !$this->shouldSaveAsDraft;
            $record->save();
            
        }

        // Alberto test
        
        $this->emit('updateRevisions', $record->id);

        return $record;
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()
            ->color('success')
            ->label(fn(EditRecord $livewire) => $livewire->getRecord()->isPublished()
                ? __('filament::resources/pages/edit-record.form.actions.save.label')
                : __('filament-drafts::actions.publish')
            );
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getFormActions(): array
    {
        return [
            ...array_slice(parent::getFormActions(), 0, 1),
            SaveDraftAction::make(),
            UnpublishAction::make(),
            ...array_slice(parent::getFormActions(), 1),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return $this->shouldSaveAsDraft
            ? 'Draft saved'
            : 'Published';
    }

    protected function getSavedNotification(): ?Notification
    {
        $notification = parent::getSavedNotification();

        $this->shouldSaveAsDraft = false;

        return $notification;
    }

}
