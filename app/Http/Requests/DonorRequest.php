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
                'birthday' => 'required|date',
                'address' => 'required|string',
                'gender' => 'required|string',
                'age' => 'required|integer',
                'email_address' => 'required|string|email',
                'phonenumber' => 'required|string',
                'blood_type' => 'required|string',
                'medical_history' => 'nullable|string|max:255',
                'current_medications' => 'string|max:255|nullable',
                'previous_donation' => 'string|nullable',
                'allergies' => 'string|nullable',
                'emergency_name' => 'required|string|max:255',
                'emergency_relationship' => 'required|string|max:255',
                'emergency_phonenumber' => 'required|integer',
                'user_id' => 'required|integer',
                'status' => 'string|nullable',
            ];
        } else if (request()->routeIs('donor.update')) {
            return [
                'fullname' => 'string|max:255|nullable',
                'birthday' => 'date|nullable',
                'address' => 'string|nullable',
                'gender' => 'string|nullable',
                'age' => 'integer|nullable',
                'email_address' => 'string|email|nullable',
                'phonenumber' => 'string|nullable',
                'blood_type' => 'string|nullable',
                'medical_history' => 'string|max:255|nullable',
                'current_medications' => 'string|nullable',
                'previous_donation' => 'string|nullable',
                'allergies' => 'string|nullable',
                'emergency_name' => 'string|max:255|nullable',
                'emergency_relationship' => 'string|max:255|nullable',
                'emergency_phonenumber' => 'integer|min:8|nullable',
            ];
        } else if (request()->routeIs('status.update')) {
            return [
                'status' => 'required|string',
            ];
        } else if (request()->routeIs('donor.register')) {
            return [
                'email' => 'required|string|email|unique:App\Models\Donor,email|max:255',
                'password' => 'required|min:8|confirmed',
            ];
        }
    }
}
