<?php

namespace App\Models\Resources;

use App\Orchid\Presenters\Resources\YelpItemPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class YelpItem extends Model
{
    use AsSource, Filterable, Attachable, Searchable;

    protected $connection = 'yelp';
    protected $table = 'yelp_item';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'name',
        'rating',
        'reviewscount',
        'url',
        'yelp_url',
        'phone',
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
        'reviewscount',
        'url',
        'yelp_url',
        'phone',
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
        'url'
    ];

    /**
     * Get location.
     */
    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn() => collect([$this->country, $this->state_region, $this->city, $this->address, $this->zip])
                ->filter(fn($v) => !empty($v))
                ->join(', ')
        );
    }

    protected $casts = [
        'rating'       => 'double',
        'reviewscount' => 'integer'
    ];

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'phone',
        'url'
    ];

    /**
     * Name of columns to which http filtering can be applied
     */
    protected $allowedFilters = [
        'id'    => Where::class,
        'name'  => Like::class,
        'phone' => Like::class,
        'url'   => Like::class,
    ];

    public static function slug(): string
    {
        return \Str::snake(str_replace('Item', '', class_basename(YelpItem::class)));
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return Str::snake(class_basename(YelpItem::class)) . '_index';
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
     * @return YelpItemPresenter
     */
    public function presenter(): YelpItemPresenter
    {
        return new YelpItemPresenter($this);
    }
}
