<?php

namespace App\Models\Resources;

use App\Orchid\Presenters\Resources\NDItemPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Screen\AsSource;

class NDItem extends Model
{
    use AsSource, Filterable, Attachable, Searchable;

    protected $connection = 'nd';
    protected $table = 'nd_item';

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'updated_on';

    protected $fillable = [
        'name',
        'url',
        'nd_url',
        'phone',
        'email',
        'address',
        'streetnumber',
        'unitnumber',
        'city',
        'state_region',
        'zip',
        'country',
        'route',
        'alias',
        'bizid'
    ];

    public const SCOUT_SEARCHABLE_ATTRIBUTES = [
        'name',
        'url',
        'nd_url',
        'phone',
        'email',
        'address',
        'streetnumber',
        'unitnumber',
        'city',
        'state_region',
        'zip',
        'country',
        'route',
        'alias',
        'bizid'
    ];

    public const TABLE_COLUMNS = [
        'name',
        'phone',
        'email',
        'url'
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

    /**
     * Name of columns to which http sorting can be applied
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'phone',
        'email',
        'url'
    ];

    /**
     * Name of columns to which http filtering can be applied
     */
    protected $allowedFilters = [
        'id'    => Where::class,
        'name'  => Like::class,
        'phone' => Like::class,
        'email' => Like::class,
        'url'   => Like::class,
    ];

    public static function slug(): string
    {
        return \Str::snake(str_replace('Item', '', class_basename(NDItem::class)));
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
     * @return NDItemPresenter
     */
    public function presenter(): NDItemPresenter
    {
        return new NDItemPresenter($this);
    }
}
