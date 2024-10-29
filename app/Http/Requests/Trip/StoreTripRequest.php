<?php

namespace App\Http\Requests\Trip;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
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
        $today = Carbon::now()->startOfDay();

        $two_days_from_now = $today->addDays(2);

        return [
            'name' => 'required',
            'description' => 'required',
            'start_at' => 'required|date|date_format:Y-m-d\TH:i|after:' . $two_days_from_now,
            'coordinates_start_lat' => 'required',
            'coordinates_start_long' => 'required',
            'distance' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'level' => 'required',
            'max_participants' => 'required|numeric|min:2',
        ];
    }
}
