<?php

namespace App\Http\Requests\Web\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingRequest extends FormRequest
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
            'settings.whatsapp' => ['required', 'string', 'min:10', 'max:20'],
            'settings.email' => ['required', 'email', 'max:255'],
            'settings.working_hours' => ['required', 'string', 'max:100'],
            'settings.off_days' => ['required', 'string', 'max:255'],

            // Logo & OG Images
            'settings.site_logo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'settings.og_image_home' => ['nullable', 'image', 'max:2048'],
            'settings.og_image_post_index' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
