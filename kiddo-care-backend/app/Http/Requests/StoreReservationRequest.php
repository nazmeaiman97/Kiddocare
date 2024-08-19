<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
        return [
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'start_time' => 'required|date|after_or_equal:now+6 hours|before_or_equal:now+30 days',
            'duration_minutes' => 'required|integer|min:60|max:1440',
            'children' => 'required|array|max:4',
            'children.*.name' => 'required|string',
            'children.*.birthdate' => 'required|date|after_or_equal:' . Carbon::now()->subMonths(12)->toDateString() . '|before_or_equal:' . Carbon::now()->subMonths(1)->toDateString(),
        ];
    }

    /**
     * Get custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_time.required' => 'The reserve time is required.',
            'start_time.after_or_equal' => 'The reserve time must be at least 6 hours from now.',
            'start_time.before_or_equal' => 'The reserve time must be no more than 30 days from now.',
            'duration_minutes.min' => 'The duration must be at least 60 minutes / 1 hour.',
            'duration_minutes.max' => 'The duration cannot exceed 1440 minutes (24 hours).',
            'children.required' => 'At least one child is required.',
            'children.max' => 'You can only add up to 4 children.',
            'children.*.name.required' => 'Each child must have a name.',
            'children.*.name.string' => 'The name of each child must be a valid string.',
            'children.*.birthdate.required' => 'Each child must have a birthdate.',
            'children.*.birthdate.date' => 'Each child’s birthdate must be a valid date.',
            'children.*.birthdate.after_or_equal' => 'Each child’s birthdate must be at least 12 months ago.',
            'children.*.birthdate.before_or_equal' => 'Each child’s birthdate must be no more than 1 month ago.',
        ];
    }
}
