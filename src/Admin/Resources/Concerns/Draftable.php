<?php

namespace Guava\FilamentDrafts\Admin\Resources\Concerns;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;

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
        if (! Arr::has(class_uses(static::$model), HasDrafts::class)) {
            throw new Exception('The resource\'s associated model must implement the HasDrafts trait.');
        }

        return parent::getEloquentQuery()->withDrafts();
    }
}
