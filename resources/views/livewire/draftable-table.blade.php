<div>
	<div @class([
    	'filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4'
    ])>
		<div>
			<x-filament-panels::header.simple
                :logo="false"
                :heading="__('filament-drafts::tables.draftable-table.title')"
            />
		</div>
	</div>

	{{ $this->table }}
</div>
