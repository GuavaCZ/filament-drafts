@props([
    'active' => false,
    'disabled' => false,
    'icon' => null,
    'iconAlias' => null,
    'label' => null,
    'separator' => false,
    'published' => false,
    'draft' => false,
])

@php
    $hasIcon = filled($icon);
    $hasLabel = filled($label) || $separator;
    $isDisabled = $disabled || $separator;
@endphp

<li
    @class([
        'overflow-hidden border-x-[0.5px] border-gray-200 first:rounded-s-lg first:border-s-0 last:rounded-e-lg last:border-e-0 dark:border-white/10',
        'focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600 dark:focus-within:ring-primary-500' => ! $isDisabled,
    ])
>
    <a
        p="{{$published}}"
        {{
            $attributes
                ->merge([
                    'disabled' => $isDisabled,
                    'type' => 'button',
                ], escape: false)
                ->class([
                    'fi-pagination-item relative overflow-hidden p-2 text-sm font-semibold outline-none transition duration-75',
                    'text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400' => $hasIcon,

                    'text-gray-700 dark:text-gray-200' => $hasLabel && (! ($active || $isDisabled)),
                    'hover:bg-gray-50 dark:hover:bg-white/5' => ! $isDisabled,
                    '!text-success-600 dark:text-success-400 ring-success-500 ring-2 outline-none' => $published,
                    'text-gray-500 dark:text-gray-400 ring-gray-300 ring-2 outline-none' => $draft,
                    'text-primary-600 dark:text-primary-400 ring-primary-500 ring-2 outline-none' => $active,
                    'cursor-default' => $separator,
                ])
        }}
    >
        @if ($hasIcon)
            <x-filament::icon
                :alias="$iconAlias"
                :icon="$icon"
                @class([
                    'fi-pagination-item-icon h-5 w-5',
                ])
            />
        @endif

        @if ($hasLabel)
            <span class="px-1.5">
                {{ $label ?? '...' }}
            </span>
        @endif
    </a>
</li>
