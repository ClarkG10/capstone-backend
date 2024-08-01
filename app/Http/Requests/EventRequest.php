<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        if (request()->routeIs('event.store')) {
            return [
                'event_name' => 'required|string|max:255',
                'event_location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'description' => 'required|string',
                'gender' => 'required|string|max:255',
                'weight' => 'string|max:255|nullable',
                'min_age' => 'integer|nullable',
                'max_age' => 'integer|nullable',
                'contact_info' => 'required|string|max:255',
                'status' => 'required|string|max:255',
                'additional_description' => 'string|nullable',
                'user_id' => 'required|integer',
            ];
        } else if (request()->routeIs('event.update')) {
            return [
                'event_name' => 'required|string|max:255',
                'event_location' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'description' => 'required|string',
                'gender' => 'required|string|max:255',
                'weight' => 'string|max:255|nullable',
                'min_age' => 'integer|required',
                'max_age' => 'integer|nullable',
                'contact_info' => 'required|string|max:255',
                'additional_description' => 'string|nullable',
            ];
        } else if (request()->routeIs('event.status')) {
            return [
                'status' => 'required|string|max:255',
            ];
        }
    }
}
