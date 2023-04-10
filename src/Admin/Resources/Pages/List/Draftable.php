<?php

namespace Guava\FilamentDrafts\Admin\Resources\Pages\List;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Draftable
 *
 *
 * @property string $layout
 *
 * @method array getViewData()
 * @method array getLayoutData()
 */
trait Draftable
{

    /**
     * Returns the custom view for the page.
     */
    public static function getView(): string
    {
        return 'filament-drafts::filament.list-draftable-records';
    }

    /**
     * Extends the table query to exclude drafts.
     */
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withoutDrafts();
    }

    /**
     * Overrides the view and renders it.
     */
    public function render(): View
    {
        return view(static::getView(), $this->getViewData())
            ->layout(static::$layout, $this->getLayoutData());
    }
}
