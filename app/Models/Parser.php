<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Orchid\Screen\AsSource;

/**
 * @property ParserStatus $last_status
 */
class Parser extends Model
{
    use AsSource;

    protected $fillable = [
        'parser_id',
        'name'
    ];

    /**
     * Get last status.
     */
    protected function lastStatus(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->statuses()->latest()->first(),
        );
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(ParserStatus::class, 'parser_id', 'id');
    }
}
