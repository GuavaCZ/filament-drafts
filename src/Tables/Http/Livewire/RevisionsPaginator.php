<?php

namespace Guava\FilamentDrafts\Tables\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RevisionsPaginator extends Component
{
    public Collection $revisions;
    public ?Model $previousRevision;
    public ?Model $nextRevision;

    public Model $record;

    public string $resource;

    public array $counts;

    protected $listeners = [
        'updateRevisions' => 'updateRevisions',
    ];

    /**
     * Updates the revisions list.
     *
     * @param int $id
     * @return void
     */
    public function updateRevisions(int $id): void
    {
        $record = $this->record::withDrafts()->find($id);

        $this->revisions = $record->revisions()
//            ->orderByDesc('is_current')
            ->orderByDesc('updated_at')
            ->get();
        $this->counts = [
            'published' => $this->revisions->where('is_published', true)->count(),
            'drafts' => $this->revisions->where('is_published', false)->where('is_current', true)->count(),
            'revisions' => $this->revisions->where('is_published', false)->where('is_current', false)->count(),
        ];

        $index = $this->revisions->search($record);
        $this->previousRevision = $this->revisions->get($index - 1);
        $this->nextRevision = $this->revisions->get($index + 1);
    }

    public function mount(string $resource, Model $record): void
    {
        $this->resource = $resource;
        $this->record = $record;

        $this->updateRevisions($this->record->id);
    }

    public function render(): View
    {
        return view('filament-drafts::livewire.revisions-paginator');
    }
}
