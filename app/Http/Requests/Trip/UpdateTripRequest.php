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
        $trip = $this->route('trip');
        $min = $trip->users()->count();

        if($min < 2)
        {
            $min = 2;
        }

        return [
            'description' => 'nullable',
            'coordinates_start_lat' => 'required',
            'coordinates_start_long' => 'required',
            'distance' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'level' => 'required',
            'max_participants' => 'required|numeric|min:'.$min,
        ];
    }
}
