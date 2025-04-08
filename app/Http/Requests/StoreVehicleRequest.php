<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return $request->user()->tokenCan('vehicles:create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => ['required', 'string'],
            'type' => ['required', Rule::in(['car', 'scooter', 'bike'])],
            'battery_capacity' => ['required', 'integer'],
            'status' => ['required', Rule::in(['available', 'rented', 'maintenance'])],
            'hourly_rate' => ['required', 'decimal:2'],
            'image' => ['sometimes', 'image', 'max:2048'] // max 2MB
        ];
    }
}
