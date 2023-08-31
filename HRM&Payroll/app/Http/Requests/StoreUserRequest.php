<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|max:150',
            'lastName' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'mobile' => 'required|max:15',
        ];
    }
}
