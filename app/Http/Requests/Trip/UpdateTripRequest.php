<?php

namespace App\Http\Requests\Trip;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
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
            'name' => 'required',
            'start_at' => 'required',
            'x_start' => 'required',
            'y_start' => 'required',
            'distance' => 'required|numeric',
            'duration' => 'required|numeric',
            'level' => 'required',
            'max_participants' => 'required|numeric',
        ];
    }
}
