<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestBloodRequest extends FormRequest
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
        if (request()->routeIs('request.store')) {
            return [
                'blood_type' => 'required|string|max:255',
                'component' => 'required|string|max:255',
                'urgency_scale' => 'required|string',
                'quantity' => 'required|integer',
                'status' => 'required|string|max:255',
                'user_id' => 'required|integer',
            ];
        } else if (request()->routeIs('request.update')) {
            return [
                'status' => 'string',
            ];
        }
    }
}
