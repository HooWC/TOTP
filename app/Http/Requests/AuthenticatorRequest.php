<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'account_name' => ['required', 'string', 'max:255'],
                    'secret_key' => ['required', 'string']
                ];
            case 'PATCH':
                return [
                    'authenticator_id' => ['required', 'integer', 'exists:authenticators,id'],
                    'account_name' => ['required', 'string', 'max:255']
                ];
            case 'DELETE':
                return [
                    'authenticator_id' => ['required', 'integer', 'exists:authenticators,id']
                ];
            default:
                return [];
        }
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        return $validated;
    }

}
