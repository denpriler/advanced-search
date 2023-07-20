<?php

namespace App\Orchid\Screens;

use App\Models\Parser;
use App\Models\ParserStatus;
use JetBrains\PhpStorm\ArrayShape;
use Orchid\Screen\Action;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout as LayoutFacade;

class ParserHistoryScreen extends Screen
{
    /**
     * @var Parser $parser
     */
    public $parser;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    #[ArrayShape(['parser' => "\App\Models\Parser"])]
    public function query(Parser $parser): iterable
    {
        $parser->load([
            'statuses' => function ($query) {
                return $query->limit(5)->latest();
            }
        ]);
        return [
            'parser' => $parser
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->parser->name;
    }

    /**
     * The description displayed in the header.
     */
    public function description(): ?string
    {
        return __('resources.description.history', ['count' => 5]);
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
     * @return Layout[]|string[]
     */
    public function layout(): iterable
    {
        return $this->parser->statuses->map(
            fn(ParserStatus $status) => LayoutFacade::legend('status', [
                Sight::make(ucfirst(__('validation.attributes.status')))
                    ->render(fn() => e($status->status)),
                Sight::make(ucfirst(__('validation.attributes.reason')))
                    ->canSee(!!$status->status_reason)
                    ->render(fn() => e($status->status_reason)),
                Sight::make(ucfirst(__('validation.attributes.proxies')))
                    ->render(fn() => e($status->proxies_alive)),
            ])
        );
    }
}
