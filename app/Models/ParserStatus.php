<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class ParserStatus extends Model
{
    use AsSource;

    protected $fillable = [
        'parser_id',
        'status',
        'status_reason',
        'proxies_alive'
    ];

    protected $casts = [
        'parser_id' => 'integer'
    ];

    public function parser(): BelongsTo
    {
        return $this->belongsTo(Parser::class, 'parser_id', 'id');
    }
}
