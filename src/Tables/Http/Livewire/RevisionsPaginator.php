<?php

namespace Guava\FilamentDrafts\Tables\Http\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Computed;

class RevisionsPaginator extends Component
{
    public Collection $revisions;

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
        $record = $this->record::withoutGlobalScopes([
            SoftDeletingScope::class,
        ])->withDrafts()->find($id);

        $this->revisions = $record->revisions()
            ->orderByDesc('updated_at')
            ->get();

        $this->counts = [
            'published' => $this->revisions->where('is_published', true)->count(),
            'drafts' => $this->revisions->where('is_published', false)->where('is_current', true)->count(),
            'revisions' => $this->revisions->where('is_published', false)->where('is_current', false)->count(),
        ];
    }

    public function mount(string $resource, Model $record): void
    {
        $this->resource = $resource;
        $this->record = $record;

        $this->updateRevisions($this->record->id);
    }

    #[Computed]
    public function publishedAndDraftRevision()
    {
        return $this->revisions
            ->filter(fn ($revision) => $revision->isPublished() || $revision->is_current);
    }

    #[Computed]
    public function otherRevisions()
    {
        return $this->revisions;
        // ->filter(fn ($revision) => ! $revision->isPublished() && ! $revision->is_current);
    }

    public function switchVersion($url)
    {
        return $this->redirect($url, navigate: true);
    }

    public function render(): View
    {
        return view('filament-drafts::livewire.revisions-paginator');
    }
}
