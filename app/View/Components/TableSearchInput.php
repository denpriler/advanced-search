<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Builder;
use Orchid\Screen\Fields\Input;

class TableSearchInput extends Component
{
    private string $parameter;

    /**
     * Create a new component instance.
     */
    public function __construct(string $parameter = null)
    {
        $this->parameter = $parameter ?? 'search';
    }

    public function search()
    {
        dd(123);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $builder = new Builder([
            Input::make('name'),
            Button::make('search')->action(route('platform.home-advisor.item.list', ['method' => 'search']))
        ]);
        return view('components.table-search-input', ['form' => $builder->generateForm()]);
    }
}
