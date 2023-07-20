<?php

namespace App\Orchid\Screens;

use App\Models\Parser;
use App\Orchid\Layouts\ParserListTable;
use JetBrains\PhpStorm\ArrayShape;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;

class ParserListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    #[ArrayShape(['items' => "\Illuminate\Contracts\Pagination\LengthAwarePaginator"])]
    public function query(): iterable
    {
        return [
            'items' => Parser::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('sidebar.labels.parsers');
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return iterable
     */
    public function layout(): iterable
    {
        return [
            ParserListTable::class
        ];
    }
}
