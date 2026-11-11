<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'not_regex:/<|>|\*|http|www\./i'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000', 'not_regex:/https?:\/\/|www\.|<a|href=|<script/i'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.not_regex' => 'The name may not contain HTML or links.',
            'message.not_regex' => 'The message may not contain URLs or HTML.',
        ];
    }
}
