<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotEmptyHtml implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): void  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Strip HTML tags and trim whitespace
        $plainText = trim(strip_tags($value));

        // If the resulting text is empty, fail the validation
        if ($plainText === '') {
            $fail(__('The :attribute field is required.'));
        }
    }
}
