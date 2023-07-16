<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class WhereLikeFilter extends Filter
{
    public function __construct(private readonly string $parameter)
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
        return $this->parameter;
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [$this->parameter];
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
        return $builder->where($this->parameter, 'LIKE', '%' . $this->request->get($this->parameter) . '%');
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
            Input::make($this->parameter)
                ->type('text')
                ->value($this->request->get($this->parameter))
                ->placeholder(__('resources.filters.where-like.placeholder', ['parameter' => $this->parameter]))
                ->title(ucfirst(__('validation.attributes.' . $this->parameter)))
        ];
    }
}
