<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DateIntervalFilter extends Filter
{
    public function __construct(private readonly string $dateColumn = 'create_at')
    {
        parent::__construct();
    }

    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('validation.attributes.created_at');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [
            'date_from',
            'date_to',
        ];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(Builder $builder): Builder
    {
        $from = $this->request->get('date_from', false);
        $to = $this->request->get('date_to', false);
        if ($from) {
            $builder = $builder->whereDate($this->dateColumn, '>=', $from);
        }
        if ($to) {
            $builder = $builder->whereDate($this->dateColumn, '<=', $to);
        }
        return $builder;
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function display(): iterable
    {
        return [
            Input::make('date_from')
                ->type('date')
                ->value($this->request->get('date_from'))
                ->placeholder(__('resources.filters.date-interval.from_placeholder'))
                ->title(__('resources.filters.date-interval.from_title')),
            Input::make('date_to')
                ->type('date')
                ->value($this->request->get('date_to'))
                ->placeholder(__('resources.filters.date-interval.to_placeholder'))
                ->title(__('resources.filters.date-interval.to_title'))
        ];
    }
}
