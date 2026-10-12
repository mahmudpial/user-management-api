<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateProjectPricingTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tier_name' => ['sometimes', 'required', 'string', 'max:255'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0', 'max:99999999.99'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'billing_type' => ['sometimes', 'in:one_time'],
            'features' => ['sometimes', 'required', 'array'],
            'features.*' => ['required', 'string', 'max:1000'],
            'source_code_file' => ['nullable', 'file', 'mimes:zip', 'max:512000'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->has('discount_price') || ! $this->filled('discount_price')) {
                    return;
                }

                $tier = $this->route('tier');
                $price = (float) ($this->input('price', $tier->price));

                if ((float) $this->input('discount_price') >= $price) {
                    $validator->errors()->add('discount_price', 'The discount price must be less than the price.');
                }
            },
        ];
    }
}
