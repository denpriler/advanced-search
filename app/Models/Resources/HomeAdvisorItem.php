<?php

namespace App\Models\Resources;

use App\Orchid\Presenters\Resources\HomeAdviserItemPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
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

    public const SCOUT_SEARCHABLE_ATTRIBUTES = [
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

    public const TABLE_COLUMNS = [
        'name',
        'phone',
        'email',
        'website',
        self::CREATED_AT
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
        'website',
        self::CREATED_AT
    ];

    /**
     * Name of columns to which http filtering can be applied
     */
    protected $allowedFilters = [
        'id'             => Where::class,
        'name'           => Like::class,
        'phone'          => Like::class,
        'email'          => Like::class,
        'website'        => Like::class,
        self::CREATED_AT => WhereDateStartEnd::class
    ];

    public static function slug(): string
    {
        return \Str::snake(str_replace('Item', '', class_basename(HomeAdvisorItem::class)));
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return self::slug() . '_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return $this->toArray();
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
