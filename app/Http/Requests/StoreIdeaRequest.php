<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Ideastatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIdeaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::enum(Ideastatus::class)],
            'links' => ['nullable', 'array'],
            'links.*' => ['nullable', 'url'],
            'steps' => ['nullable', 'array'],
            'steps.*' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'links.*.url' => 'Each link must be a valid URL.',
        ];
    }
}
