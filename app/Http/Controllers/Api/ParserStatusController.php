<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParserStatus\StoreParserStatusRequest;
use App\Http\Resources\ParserResource;
use App\Models\Parser;
use App\Models\ParserStatus;

class ParserStatusController extends Controller
{
    public function __invoke(StoreParserStatusRequest $request): ParserResource
    {
        $parser = Parser::whereParserId($request->parser()['parser_id'])
            ->firstOrNew();
        $parser
            ->fill($request->parser())
            ->save();

        ParserStatus::create(array_merge($request->status(), ['parser_id' => $parser->id]));

        return ParserResource::make($parser);
    }
}
