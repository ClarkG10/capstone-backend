<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
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

        if (request()->routeIs('inventory.store')) {
            return [
                'blood_type' => 'required|string|max:255',
                'rh_factor' => 'required|string|max:255',
                'component' => 'required|string|max:255',
                'avail_blood_units' => 'required|integer',
                'user_id' => 'required|integer',
            ];
        } else if (request()->routeIs('inventory.update')) {
            return [
                'avail_blood_units' => 'integer',
            ];
        }
    }
}
