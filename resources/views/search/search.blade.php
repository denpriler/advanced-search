@extends('platform::dashboard')

@section('title', __('advanced-search.title'))

@push('head')
    @vite('resources/js/app.js')
    @vite('resources/sass/app.scss')
@endpush

@section('content')
    <div class="container-fluid" data-turbo="false">
        <form action="{{ route('platform.advanced-search') }}" method="GET">
            <div class="form-group">
                <label for="all_words" class="form-label">
                    @lang('advanced-search.labels.query')
                    <br>
                    <span class="text-secondary">@lang('advanced-search.labels.query-sub')</span>
                    <br>
                    <span
                        class="text-secondary">@lang('advanced-search.labels.example', ['example' => "tri-colour rat terrier"])</span>
                    <br>
                    <span
                        class="text-secondary">@lang('advanced-search.labels.example', ['example' => "\"rat terrier\""])</span>
                    <input class="form-control mw-100" name="all_words" value="{{ request()->query('all_words') }}">
                </label>
            </div>
            <div class="form-group">
                <label for="any_words" class="form-label">
                    @lang('advanced-search.labels.any-words-query')
                    <br>
                    <span class="text-secondary">@lang('advanced-search.labels.any-words-query-sub')</span>
                    <br>
                    <span
                        class="text-secondary">@lang('advanced-search.labels.example', ['example' => "miniature OR standard"])</span>
                    <input class="form-control mw-100" name="any_words" value="{{ request()->query('any_words') }}">
                </label>
            </div>
            <div class="form-group">
                <label for="none_words" class="form-label">
                    @lang('advanced-search.labels.none-words-query')
                    <br>
                    <span class="text-secondary">@lang('advanced-search.labels.none-words-query-sub')</span>
                    <br>
                    <span
                        class="text-secondary">@lang('advanced-search.labels.example', ['example' => "-rodent, -\"Jack Russell\""])</span>
                    <input class="form-control mw-100" name="none_words" value="{{ request()->query('none_words') }}">
                </label>
            </div>
            <div class="form-group d-flex flex-row justify-content-end">
                <a class="btn btn-link" type="button" href="{{ route('platform.advanced-search') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="me-2"
                         viewBox="0 0 16 16" role="img" path="bs.trash3" componentname="orchid-icon">
                        <path
                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"></path>
                    </svg>
                    <span>@lang('advanced-search.buttons.clear')</span>
                </a>
                <button class="btn btn-secondary" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="me-2"
                         viewBox="0 0 16 16" role="img" path="bs.check-circle" componentname="orchid-icon">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"></path>
                    </svg>
                    <span>@lang('advanced-search.buttons.search')</span>
                </button>
            </div>
        </form>

        <ul class="nav nav-tabs" id="models-tabs" role="tablist">
            @foreach($models as $index => $model)
                @if(Auth::user()->hasAccess("manager." . $model::slug()))
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($index == 0) active @endif" id="{{ $model::slug() }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ $model::slug() }}"
                                type="button"
                                role="tab" aria-controls="home" aria-selected="true"
                                aria-selected="@if($index == 0) true @else false @endif">
                            @lang('resources.labels.' . $model::slug())
                        </button>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="tab-content" id="models-tabs">
            @foreach($models as $index => $model)
                @if(Auth::user()->hasAccess("manager." . $model::slug()))
                    <div class="tab-pane fade @if($index == 0) show active @endif" id="{{ $model::slug() }}"
                         role="tabpanel"
                         aria-labelledby="{{ class_basename($model) }}">
                        <x-advanced-search-data-table model="{{ $model }}"/>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@stop
