<?php

namespace App\Orchid\Layouts;

use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ResourceFilterSelection extends Selection
{
    /**
     * @var Filter[]
     */
    private array $filters;

    /**
     * @param Filter[] $filters
     */
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ...$this->filters
        ];
    }
}
