<x-filament-panels::page :class="\Illuminate\Support\Arr::toCssClasses([
    'filament-resources-list-records-page',
    'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
])">
    {{ $this->table }}

    <livewire:filament-drafts::draftable-table :resource="static::$resource" />
</x-filament-panels::page>
