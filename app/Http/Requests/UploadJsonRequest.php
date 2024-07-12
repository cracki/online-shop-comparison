<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadJsonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jsonFile' => 'required|file|mimes:json|max:2048',
            'category' => 'required|exists:categories,id',
            'online_shop_id' => 'required|exists:online_shops,id', // Fix: Ensure it exists in the online_shops table
        ];
    }
}
