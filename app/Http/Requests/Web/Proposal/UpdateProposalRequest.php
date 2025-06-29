<?php

namespace App\Http\Requests\Web\Proposal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
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
        $proposalId = $this->route('proposal')->id;

        return [
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:proposals,slug,' . $proposalId,
            'image' => 'nullable|image|max:2048',
        ];
    }
}
