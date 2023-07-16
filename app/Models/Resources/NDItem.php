<?php

namespace App\Models\Resources;

use App\Orchid\Presenters\Resources\NDItemPresenter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
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

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'nd_item_index';
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
            'url'      => $this->url,
            'location' => $this->location,
        ];
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
