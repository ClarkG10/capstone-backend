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
                'time_start' => 'required|string',
                'time_end' => 'required|string',
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
                'event_name' => 'string|max:255',
                'event_location' => 'string|max:255',
                'start_date' => 'date',
                'end_date' => 'date',
                'time_start' => 'string',
                'time_end' => 'string',
                'description' => 'string',
                'gender' => 'string|max:255',
                'weight' => 'string|max:255|nullable',
                'min_age' => 'integer',
                'max_age' => 'integer',
                'contact_info' => 'string|max:255',
                'participants' => 'integer',
                'image' => 'image|mimes:jpg,gif,png|max:5120',
            ];
        } else if (request()->routeIs('event.status')) {
            return [
                'status' => 'required|string|max:255',
            ];
        }
    }
}
