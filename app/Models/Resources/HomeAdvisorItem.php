<?php

namespace App\Models\Resources;

use App\Orchid\Presenters\Resources\HomeAdviserItemPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class HomeAdvisorItem extends Model
{
    use AsSource, Filterable, Attachable, Searchable;

    protected $connection = 'home_advisor';
    protected $table = 'homeadvisor_item';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

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

    /**
     * Get location.
     */
    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->country . ', ' . $this->state_region . ', ' . $this->city . ', ' . $this->address . ', ' . $this->zip
        );
    }

    protected $casts = [
        'rating'            => 'double',
        'reviews_qty'       => 'integer',
        'approved_status'   => 'boolean',
        'years_in_business' => 'integer'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'phone',
        'email',
        'website'
    ];

    /**
     * Name of columns to which http filtering can be applied
     */
    protected $allowedFilters = [
        'id'      => Where::class,
        'name'    => Like::class,
        'phone'   => Like::class,
        'email'   => Like::class,
        'website' => Like::class,
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
            'id'       => $this->getKey(),
            'name'     => $this->name,
            'email'    => $this->email,
            'website'  => $this->website,
            'location' => $this->location,
        ];
    }

    /**
     * Get the presenter for the model.
     *
     * @return HomeAdviserItemPresenter
     */
    public function presenter(): HomeAdviserItemPresenter
    {
        return new HomeAdviserItemPresenter($this);
    }
}
