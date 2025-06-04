<?php

namespace App\Http\Requests\Web\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOurServiceRequest extends FormRequest
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
        $servicId = $this->route('service')->id;

        return [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:proposals,slug,' . $servicId,
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }
}
