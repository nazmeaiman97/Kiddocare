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
            'children.*.birthdate' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subMonths(1)->toDateString(), // more than 1 month or equal
                'after_or_equal:' . Carbon::now()->subYears(12)->subMonths(11)->toDateString(), // Less than 12 years old
            ],

        ];
    }


    /**
     * Get custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [
            'start_time.required' => 'The reserve time is required.',
            'start_time.after_or_equal' => 'The reserve time must be at least 6 hours from now.',
            'start_time.before_or_equal' => 'The reserve time must be no more than 30 days from now.',
            'duration_minutes.min' => 'The duration must be at least 60 minutes / 1 hour.',
            'duration_minutes.max' => 'The duration cannot exceed 1440 minutes (24 hours).',
            'children.required' => 'At least one child is required.',
            'children.max' => 'You can only add up to 4 children.',
        ];

        // Dynamically add messages for each child based on the count in the request
        $childrenCount = count($this->input('children', []));
        for ($index = 0; $index < $childrenCount; $index++) {
            $messages["children.$index.name.required"] = "Child " . ($index + 1) . " must have a name.";
            $messages["children.$index.name.string"] = "The name of child " . ($index + 1) . " must be a valid string.";
            $messages["children.$index.birthdate.required"] = "Child " . ($index + 1) . " must have a birthdate.";
            $messages["children.$index.birthdate.date"] = "The birthdate of child " . ($index + 1) . " must be a valid date.";
            $messages["children.$index.birthdate.before_or_equal"] = "The birthdate of child " . ($index + 1) . "must be atleast a month";
            $messages["children.$index.birthdate.after_or_equal"] = "The age of child " . ($index + 1) . " must be below 13";
        }

        return $messages;
    }
}
