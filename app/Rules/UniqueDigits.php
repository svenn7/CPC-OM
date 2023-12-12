<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueDigits implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Convert the value to an array of digits
        $digits = str_split($value);

        // Check if all digits are unique
        return count($digits) === count(array_unique($digits));
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must have unique digits.';
    }
}
