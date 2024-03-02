<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class UsernameValidationRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // TODO: Implement validate() method.
    }

    public function passes($attribute, $value)
    {
        // Check if the value is a valid email or phone number
        $validator = Validator::make([$attribute => $value], [
            $attribute => ['nullable', 'string'],
        ]);

        // Add custom error message for the "username" key
        $validator->setAttributeNames(['username' => 'Email or Phone Number']);

        // Check if the value is a valid email or phone number
        $passesValidation = $validator->passes() &&
            (filter_var($value, FILTER_VALIDATE_EMAIL) || $this->isValidPhoneNumber($value));

        if (!$passesValidation) {
            // If validation fails, check if the value is a phone number and exactly 12 characters long
            if (!$this->isValidPhoneNumber($value)) {
                // Return false with a custom error message
                return $this->message();
            } elseif (strlen($value) !== 12) {
                // Return false with a specific error message for phone numbers that are not 12 characters long
                return $this->message();
            }
        }

        return $passesValidation;
    }

    protected function isValidPhoneNumber($value)
    {
        // Implement phone number validation logic here
        // Return true if the phone number is valid, false otherwise
        // Example implementation: return preg_match('/your-regex-pattern/', $value);
        return strlen($value) === 12;
    }

    public function message()
    {
        return 'The username must be a valid email or phone number.';
    }

}
