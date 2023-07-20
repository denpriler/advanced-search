<?php

namespace App\Http\Resources;

use App\Models\Parser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class ParserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'last_status' => "array"])]
    public function toArray(Request $request): array
    {
        /** @var $this Parser|JsonResource */
        return [
            'name'        => $this->name,
            'last_status' => [
                'status'        => $this->last_status->status,
                'status_reason' => $this->whenNotNull($this->last_status->status_reason),
                'proxies_alive' => $this->last_status->proxies_alive
            ]
        ];
    }
}
