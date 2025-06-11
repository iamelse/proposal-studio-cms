<?php

namespace App\Http\Requests\Web\Home;

use App\Rules\NotEmptyHtml;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content.title' => ['required', 'string', 'max:255', new NotEmptyHtml],
            'content.subtitle' => ['required', 'string', 'max:255', new NotEmptyHtml],
            'content.description' => ['required', 'string', new NotEmptyHtml],
        ];
    }

    public function attributes(): array
    {
        return [
            'content.title' => 'title',
            'content.subtitle' => 'subtitle',
            'content.description' => 'description'
        ];
    }
}
