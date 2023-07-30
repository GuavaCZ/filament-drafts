<?php

namespace Guava\FilamentDrafts\Tables\Http\Livewire;

use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class DraftableTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $resource;

    public function mount(string $resource)
    {
        $this->resource = $resource;
    }

    public function table(Table $table): Table
    {
        /**
         * TODO: optionally show table actions from resource table.
         * we are able to get table actions array just like we get table columns
         * but the view and edit action do not work for some reason
         */
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns());
    }

    protected function getTableQuery(): Builder
    {
        return $this->resource::getModel()::query()->onlyDrafts()->where('is_current', true);
    }

    protected function getTableColumns(): array
    {
        return $this->resource::table(Table::make($this))
            ->getColumns();
    }

    public function render(): View
    {
        return view('filament-drafts::livewire.draftable-table');
    }
}
