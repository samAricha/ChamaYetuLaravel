<?php

namespace App\Http\Requests;

use App\Rules\UsernameValidationRule;
use App\Traits\HttpResponses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'username' => ['string', new UsernameValidationRule()],
            'password' => ['string', 'min:6']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Use methods from your HttpResponses trait to format the error response
        return $this->error([$validator->errors()->all()], 'Validation Error', 422);
    }
}
