<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
        if (request()->routeIs('staff.store')) {
            return [
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|unique:App\Models\Staff,email|max:255|unique:App\Models\User,email',
                'password' => 'required|min:8|confirmed',
                'role' => 'required|string',
                'phonenumber' => 'required|integer',
                'address' => 'required|string',
                'user_id' => 'required|integer',
            ];
        } else if (request()->routeIs('role.update')) {
            return [
                'role' => 'string',
            ];
        }
    }
}
