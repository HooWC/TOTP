<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email'],
                    'password' => ['required', 'min:6', 'max:20']
                ];
            case 'PATCH':
                return [
                    'user_id' => ['required', 'integer', 'exists:user,id'],
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'unique:users,email']
                ];
            case 'DELETE':
                return [
                    'user_id' => ['required', 'integer', 'exists:user,id']
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
