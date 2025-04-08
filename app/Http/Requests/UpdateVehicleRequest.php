<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => ['sometimes', 'string'],
            'type' => ['sometimes', Rule::in(['car', 'scooter', 'bike'])],
            'battery_capacity' => ['sometimes', 'integer'],
            'status' => ['sometimes', Rule::in(['available', 'rented', 'maintenance'])],
            'hourly_rate' => ['sometimes', 'decimal:2'],
            'image' => ['sometimes', 'image', 'max:2048'] // max 2MB
        ];
    }
}
