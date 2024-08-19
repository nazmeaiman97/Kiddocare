<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidStatus implements ValidationRule
{
    // It can be reuse, this constants should in serated shared variable files,
    // Will leave it here for now
    protected $validStatuses = [
        'pending',
        'confirmed',
        'cancelled',
        'completed',
        'no-show',
        'rejected',
        'rescheduled',
        'under-review',
        'awaiting-payment',
        'expired'
    ];

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, $this->validStatuses)) {
            $fail('The ' . $attribute . ' is not a valid status.');
        }
    }
}
