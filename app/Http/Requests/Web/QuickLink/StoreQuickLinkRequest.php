<?php

namespace App\Http\Requests\Web\QuickLink;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuickLinkRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' =>'required|string|max:255|unique:social_media,slug,' . $this->route('slug') . ',slug',
            'url' => 'required|string|max:255',
        ];
    }
}
