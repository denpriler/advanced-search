<?php

namespace App\Models\HomeAdvisor;

use App\Orchid\Presenters\HomeAdviser\HomeAdviserItemPresenter;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class HomeAdvisorItem extends Model
{
    use AsSource, Filterable, Attachable, Searchable;

    protected $connection = 'home_advisor';
    protected $table = 'homeadvisor_item';

    protected $fillable = [
        'name',
        'rating',
        'highly_rated_for',
        'reviews_qty',
        'approved_status',
        'recommend',
        'years_in_business',
        'details',
        'cities_served',
        'allservices',
        'cost',
        'website',
        'homeadvisor_url',
        'phone',
        'email',
        'address',
        'city',
        'state_region',
        'zip',
        'country',
        'alias',
        'category',
        'bizid'
    ];

    protected $casts = [
        'rating'            => 'double',
        'reviews_qty'       => 'integer',
        'approved_status'   => 'boolean',
        'years_in_business' => 'integer'
    ];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'rating'
    ];

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'home_advisor_item_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id'      => $this->getKey(),
            'name'    => $this->name,
            'rating'  => $this->rating,
            'details' => $this->details,
        ];
    }

    /**
     * Get the presenter for the model.
     *
     * @return HomeAdviserItemPresenter
     */
    public function presenter()
    {
        return new HomeAdviserItemPresenter($this);
    }
}
