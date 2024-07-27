<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'designation' => 'required|string',
            'name' => 'required|string',
            'email' => ['required', 'string', 'lowercase', 'email', 'regex:/(.+)@(.+)\.(.+)/i', 'max:255', Rule::unique(User::class)],
            'phone_number'=>'required|string|max_digits:10|min_digits:10',
            'password'=>'required|min:6'
        ];
    }
}
