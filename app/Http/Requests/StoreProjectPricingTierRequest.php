<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectPricingTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tier_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'billing_type' => ['sometimes', 'in:one_time'],
            'features' => ['required', 'array'],
            'features.*' => ['required', 'string', 'max:1000'],
            'source_code_file' => ['nullable', 'file', 'mimes:zip', 'max:512000'],
        ];
    }
}
