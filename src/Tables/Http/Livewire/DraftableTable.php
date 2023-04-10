<?php

namespace Guava\FilamentDrafts\Tables\Http\Livewire;

use Closure;
use Filament\Resources\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class DraftableTable extends Component implements HasTable
{

    use InteractsWithTable;

    public $resource;

    public function mount(string $resource)
    {
        $this->resource = $resource;
    }

    protected function getTableQuery(): Builder
    {
        return $this->resource::getModel()::query()->onlyDrafts()->where('is_current', true);
    }

    protected function getTableColumns(): array
    {
        $columns = $this->resource::table(Table::make())
            ->getColumns();

//        $columns[0]->label('ąsdasd');

        return [
//            TextColumn::make('_published')
//                ->label('Model')
//                ->formatStateUsing(fn() => new HtmlString(
//                    Blade::render(<<<blade
//<div>
//test
//</div>
//blade
//                    ))),
            ...$columns,
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn($record) => $this->resource::getUrl('edit', ['record' => $record]);
    }

    public function render(): View
    {
        return view('filament-drafts::livewire.draftable-table');
    }

}
