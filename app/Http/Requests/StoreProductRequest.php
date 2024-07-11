<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product' => 'required|string|max:1024',
            'description' => 'nullable|string|max:1024',
            "productIds"    => "array",
            "productIds.*"  => "string",
            "categoryIds" => "array",
            "categoryIds.*" => "string",
        ];
    }
}
