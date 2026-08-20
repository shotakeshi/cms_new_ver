<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OnOffRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $message = __('The selected :attribute is invalid.', compact('attribute'));

        if ($value === null || $value === '') {
            $fail($message);
        }

        if (! is_string($value) && ! is_numeric($value)) {
            $fail($message);
        }

        if (! in_array((string) $value, ['0', '1'], true)) {
            $fail($message);
        }
    }
}
