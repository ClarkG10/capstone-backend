<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
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
        if (request()->routeIs('organization.store')) {
            return [
                'org_name' => 'required|string|max:255',
                'org_type' => 'required|string|max:255',
                'org_email' => 'required|string',
                'description' => 'required|string',
                'country' => 'required|string|max:255',
                'city' => 'string|max:255|required',
                'address' => 'string|required',
                'zipcode' => 'integer|required',
                'operating_hour' => 'required|string|max:255',
                'latitude' => 'string|nullable',
                'longitude' => 'string|nullable',
                'contact_info' => 'string|required',
                'user_id' => 'required|integer',
                'info_complete' => 'string|nullable',
            ];
        } else if (request()->routeIs('organization.update')) {
            return [
                'org_name' => 'required|string|max:255',
                'org_type' => 'required|string|max:255',
                'org_email' => 'required|string',
                'description' => 'required|string',
                'country' => 'required|string|max:255',
                'city' => 'string|max:255|required',
                'address' => 'integer|required',
                'zipcode' => 'integer|required',
                'operating_hour' => 'required|string|max:255',
                'contact_info' => 'string|required',

            ];
        }
    }
}
