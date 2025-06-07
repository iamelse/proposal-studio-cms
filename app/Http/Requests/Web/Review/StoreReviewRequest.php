<?php

namespace App\Http\Requests\Web\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'rating' => [
                'required',
                'numeric',
                'between:0,5',
                'regex:/^(0|0\.5|1|1\.5|2|2\.5|3|3\.5|4|4\.5|5)$/'
            ],
            'comment' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'image' => 'string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.between' => 'Rating must be between 0 and 5.',
            'rating.regex' => 'Rating must be in increments of 0.5, e.g., 3.5 or 4.0.',
        ];
    }
}
