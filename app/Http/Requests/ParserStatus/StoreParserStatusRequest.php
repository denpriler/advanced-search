<?php

namespace App\Http\Requests\ParserStatus;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreParserStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['parser_id' => "string", 'name' => "string", 'status' => "string", 'status_reason' => "string", 'proxies_alive' => "string"])]
    public function rules(): array
    {
        return [
            'parser_id'     => 'required:string',
            'name'          => 'nullable:string',
            'status'        => 'required:string',
            'status_reason' => 'nullable:string',
            'proxies_alive' => 'required:string',
        ];
    }

    #[ArrayShape(['parser_id' => "mixed", 'name' => "mixed"])]
    public function parser(): array
    {
        return [
            'parser_id' => $this->validated('parser_id'),
            'name'      => $this->validated('parser_id', 'Parser ' . $this->validated('parser_id'))
        ];
    }

    public function status(): array
    {
        return $this->only(['status', 'status_reason', 'proxies_alive']);
    }
}
