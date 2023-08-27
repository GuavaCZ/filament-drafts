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

        <div class="mt-2 sm:mt-0 flex w-full gap-x-3 items-center justify-end">
            @php
                $isRtl = __('filament-panels::layout.direction') === 'rtl';
            @endphp

            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20">
                <x-filament::tabs label="Content tabs" style="padding: 0">
                    @foreach ($this->publishedAndDraftRevision as $revision)
                        <x-filament::tabs.item
                            :active="$revision->id === $record->id"
                            :disabled="$revision->id === $record->id"
                            wire:click="switchVersion('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                        >
                            {{ $revision->isPublished() ? 'Published' : 'Draft' }}
                        </x-filament::tabs.item>
                    @endforeach
                </x-filament::tabs>
            </div>

            <ol
                class="justify-self-end rounded-lg bg-white shadow-sm ring-1 ring-gray-950/10 dark:bg-white/5 dark:ring-white/20 flex"
            >
                @foreach ($this->otherRevisions as $revision)
                    <x-filament-drafts::pagination-item
                        :active="$revision->id === $record->id"
                        :disabled="$revision->id === $record->id"
                        :label="$loop->iteration"
                        wire:click="switchVersion('{{ $resource::getUrl('edit', ['record' => $revision]) }}')"
                    />
                @endforeach
            </ol>
        </div>
    </div>
