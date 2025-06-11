<?php

namespace App\Http\Requests\Web\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
        $eventId = $this->route('event')->id;

        return [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:events,slug,' . $eventId,
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }
}
