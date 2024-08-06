<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorRequest extends FormRequest
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
        if (request()->routeIs('donor.store')) {
            return [
                'fullname' => 'required|string|max:255',
                'birthday' => 'required|date|max:255',
                'gender' => 'required|date',
                'address' => 'required|string',
                'email' => 'required|string|email',
                'phonenumber' => 'required|string',
                'blood_type' => 'required|string',
                'medical_history' => 'nullable|string|max:255',
                'current_medications' => 'string|max:255|nullable',
                'previous_donation' => 'required|string|nullable',
                'allergies' => 'string|nullable',
                'emergency_name' => 'required|string|max:255',
                'emergency_relationship' => 'required|string|max:255',
                'emergency_phonenumber' => 'required|integer|min:8',
                'user_id' => 'required|integer',
            ];
        } else if (request()->routeIs('donor.update')) {
            return [
                'fullname' => 'required|string|max:255',
                'birthday' => 'required|date|max:255',
                'gender' => 'required|date',
                'address' => 'required|string',
                'email' => 'required|string|email',
                'phonenumber' => 'required|string',
                'blood_type' => 'required|string',
                'medical_history' => 'nullable|string|max:255',
                'current_medications' => 'string|max:255|nullable',
                'previous_donation' => 'required|string|nullable',
                'allergies' => 'string|nullable',
                'emergency_name' => 'required|string|max:255',
                'emergency_relationship' => 'required|string|max:255',
                'emergency_phonenumber' => 'required|integer|min:8',
            ];
        }
    }
}
