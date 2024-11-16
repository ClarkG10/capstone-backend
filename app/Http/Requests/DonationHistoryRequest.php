<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationHistoryRequest extends FormRequest
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
        if (request()->routeIs('donationhistory.store')) {
            return [
                'units' => 'required|integer',
                'component' => 'required|string',
                'donation_date' => 'required|date',
                'donor_id' => 'required|integer',
            ];
        }
    }
}
