<?php

namespace Guava\FilamentDrafts\Concerns;

trait HasDrafts
{
    use \Oddvalue\LaravelDrafts\Concerns\HasDrafts;

    public function initializeHasDrafts(): void
    {
        $this->fillable[] = 'is_published';
    }

}
