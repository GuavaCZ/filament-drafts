<?php

namespace Guava\FilamentDrafts\Admin\Resources\Pages\List;

use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;

trait Draftable
{
   public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->withoutDrafts()),
            'drafts' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->onlyDrafts()->where('is_current', true)),
        ];
    }
}
