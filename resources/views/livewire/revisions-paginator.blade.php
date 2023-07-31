<div class="flex flex-col justify-between gap-2 px-4 py-3 md:flex-row">
    <div class="flex w-full flex-col">
        <span class="text-lg font-medium">{{ __('filament-drafts::paginator.title') }}</span>
        <div>
            {{ __('filament-drafts::paginator.counts.overview', [
                'published' => trans_choice('filament-drafts::paginator.counts.published', $counts['published']),
                'drafts' => trans_choice('filament-drafts::paginator.counts.drafts', $counts['drafts']),
                'revisions' => trans_choice('filament-drafts::paginator.counts.revisions', $counts['revisions'], [
                    'max' => config('drafts.revisions.keep'),
                ]),
            ]) }}
        </div>

        <div class="flex w-full items-center justify-end">
            @php
                $isRtl = __('filament-panels::layout.direction') === 'rtl';
            @endphp

            <x-filament::tabs label="Content tabs">
                @foreach ($this->publishedAndDraftRevision as $revision)
                    <x-filament::tabs.item
                        :active="$revision->id === $record->id"
                        :disabled="$revision->id === $record->id"
                        wire:click="redirectTo('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                    >
                        {{ $revision->isPublished() ? 'Published' : 'Draft' }}
                    </x-filament::tabs.item>
                @endforeach
            </x-filament::tabs>

            <ol
                class="hidden justify-self-end rounded-lg bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20 md:flex"
            >
                @isset($previousRevision)
                    <x-filament-drafts::pagination-item
                        :aria-label="__('filament::components/pagination.actions.previous.label')"
                        :icon="$isRtl ? 'heroicon-m-chevron-right' : 'heroicon-m-chevron-left'"
                        icon-alias="pagination.previous-button"
                        rel="prev"
                        :disabled="$revision->id === $record->id"
                        wire:click="redirectTo('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                    />
                @endisset

                @foreach ($this->otherRevisions as $revision)
                    <x-filament-drafts::pagination-item
                        :active="$revision->id === $record->id"
                        :disabled="$revision->id === $record->id"
                        :label="$loop->iteration"
                        wire:click="redirectTo('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                    />
                @endforeach

                @isset($nextRevision)
                    <x-filament-drafts::pagination-item
                        :aria-label="__('filament::components/pagination.actions.next.label')"
                        :icon="$isRtl ? 'heroicon-m-chevron-left' : 'heroicon-m-chevron-right'"
                        icon-alias="pagination.next-button"
                        rel="next"
                        :disabled="$revision->id === $record->id"
                        wire:click="redirectTo('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                    />
                @endisset
            </ol>
        </div>
    </div>
