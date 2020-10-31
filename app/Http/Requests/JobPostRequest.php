<?php

namespace Treiner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:32',
            'type' => ['required', Rule::in(config('treiner.sessions'))],
            'latitude' => 'required|numeric|min:-90|max:90',
            'longitude' => 'required|numeric|min:-180|max:180',
            'locality' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'length' => 'required|integer|max:180|min:30',
            'starts' => 'required|date|after:now|before:+80 days',
            'fee' => 'required|numeric|max:25000|min:0.50',
            'details' => 'required|max:5000|min:50|string',
            'time' => 'required|date_format:H:i'
        ];
    }
}
