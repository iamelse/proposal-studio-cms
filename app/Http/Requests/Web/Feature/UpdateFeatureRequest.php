<?php

namespace App\Http\Requests\Web\Feature;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeatureRequest extends FormRequest
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
        $featureId = $this->route('feature')->id;

        return [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:skills,slug,' . $featureId,
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }
}
