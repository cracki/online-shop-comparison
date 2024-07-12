<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'colesProductIds' => 'required|array',
            'colesProductIds.*' => 'required',
            'woolworthsProductIds' => 'required|array',
            'woolworthsProductIds.*' => 'required',
        ];
    }
}
