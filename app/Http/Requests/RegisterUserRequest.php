<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidationRule;
use App\Traits\HttpResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class RegisterUserRequest extends FormRequest
{
    use HttpResponses;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required',  'email', 'unique:users'],
            'phone' => ['required', new PhoneValidationRule(), 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

    }

    protected function failedValidation(Validator $validator)
    {
        // Use methods from your HttpResponses trait to format the error response
        return $this->error(
            [$validator->errors()->all()],
            'Validation Error',
            ResponseAlias::HTTP_OK
        );
    }
}
