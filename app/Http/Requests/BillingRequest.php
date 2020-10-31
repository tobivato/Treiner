<?php

namespace Treiner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BillingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'streetAddress' => 'required|string',
            'locality' => 'required|string',
            'country' => ['required', Rule::in(array_keys(config('treiner.countries')))],
            'state' => 'required|string',
            'postcode' => 'required|integer',
            'players-name' => 'required|array|max:12',
            'players-age' => 'required|array|max:12',
            'players-medical' => 'required|array|max:12',
            'stripeToken' => 'required_if:payment-method,card',
            'payment-method' => 'required|in:cash,card',
        ];
    }
}
