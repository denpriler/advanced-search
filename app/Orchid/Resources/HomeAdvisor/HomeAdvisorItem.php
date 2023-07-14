<?php

namespace App\Orchid\Resources\HomeAdvisor;

use Orchid\Screen\Sight;
use Orchid\Crud\Resource;
use Orchid\Screen\TD;
use App\Models\HomeAdvisor\HomeAdvisorItem as ResourceModel;

class HomeAdvisorItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ResourceModel::class;

    /**
     * Get the permission key for the resource.
     *
     * @return string|null
     */
    public static function permission(): ?string
    {
        return 'manager.home_advisor';
    }

    /**
     * Get the resource should be displayed in the navigation
     *
     * @return bool
     */
    public static function displayInNavigation(): bool
    {
        return false;
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label(): string
    {
        return __('resources.labels.items');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel(): string
    {
        return __('resources.labels.item');
    }

    /**
     * Get the text for the list breadcrumbs.
     *
     * @return string
     */
    public static function listBreadcrumbsMessage(): string
    {
        return __('sidebar.resources.home_advisor') . ' / ' . static::label();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name')
                ->sort(),
            TD::make('rating')
                ->sort()
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('name', mb_convert_case(__('validation.attributes.name'), MB_CASE_TITLE, "UTF-8")),
            Sight::make('rating', mb_convert_case(__('validation.attributes.rating'), MB_CASE_TITLE, "UTF-8")),
            Sight::make('details', mb_convert_case(__('validation.attributes.description'), MB_CASE_TITLE, "UTF-8")),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }
}
