<?php

namespace App\Http\Requests\api\v1\Review;

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
            'review' => ['sometimes', 'required', 'string', 'max:255'],
            'rating' => ['sometimes', 'required', 'integer', 'between:1,5'],
        ];
    }
}
