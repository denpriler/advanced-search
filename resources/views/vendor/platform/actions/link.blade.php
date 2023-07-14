@component($typeForm, get_defined_vars())
    <a
        data-turbo="{{ var_export($turbo) }}"
        {{ $attributes }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
        @endisset

        <span>{{ __("resources.actions.$slug") ?? $name ?? '' }}</span>
    </a>
@endcomponent
