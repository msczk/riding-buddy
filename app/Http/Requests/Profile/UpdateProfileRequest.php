<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'firstname' => ['sometimes', 'string', 'nullable'],
            'lastname' => ['sometimes', 'string', 'nullable'],
            'description' => ['sometimes', 'string', 'nullable'],
            'riding_level' => ['required', 'numeric'],
            'bike' => ['required', 'numeric'],
            'birthday' => ['sometimes', 'nullable', 'date'],
            'optin_newsletter' => ['sometimes'],
            'location' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
