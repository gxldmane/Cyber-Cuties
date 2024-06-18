<?php

namespace App\Http\Requests\api\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'bio' => ['sometimes', 'nullable', 'string', 'max:255'],
            'avatar' => ['sometimes', 'nullable', 'image', 'max:1024'],
            'cover' => ['sometimes', 'nullable', 'image', 'max:1024'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
