<?php

namespace App\Orchid\Layouts;

use App\Models\Parser;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ParserListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'items';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('parser_id', 'ID')
                ->render(function (Parser $parser) {
                    return Link::make($parser->parser_id)
                        ->route('platform.parser.history', $parser);
                }),
            TD::make('name', ucfirst(__('validation.attributes.name'))),
            TD::make('status', ucfirst(__('validation.attributes.status')))
                ->render(fn(Parser $parser) => e($parser->last_status->status)),
            TD::make('reason', ucfirst(__('validation.attributes.reason')))
                ->render(fn(Parser $parser) => e($parser->last_status->status_reason)),
            TD::make('last_update', ucfirst(__('validation.attributes.updated_at')))
                ->render(fn(Parser $parser) => e($parser->last_status->updated_at)),
        ];
    }
}
