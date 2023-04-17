<?php

namespace Guava\FilamentDrafts\Admin\Resources\Concerns;

use Exception;
use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * Draftable trait for Filament resources.
 *
 * @property string $model
 */
trait Draftable
{
    /**
     * Extends the eloquent query to include drafts.
     *
     * @return Builder
     * @throws Exception
     */
    public static function getEloquentQuery(): Builder
    {
        if (! Arr::hasAny(class_uses(static::$model), [HasDrafts::class, \Oddvalue\LaravelDrafts\Concerns\HasDrafts::class])) {
            throw new Exception('The resource\'s associated model must implement the HasDrafts trait.');
        }

        return parent::getEloquentQuery()->withDrafts();
    }
}
