<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        '_type' => 'required|string|max:1024',
        'availability' => 'nullable|boolean',
        'now' => 'nullable|numeric',
        'name' => 'nullable|string|max:1024',
        'size' => 'nullable|string|max:1024',
        'description' => 'nullable|string|max:1024',
        'availabilityType' => 'nullable|string|max:1024',
    ];
    }
}
