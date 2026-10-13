<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InitiateProjectOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pricing_tier_id' => ['required', 'integer', 'exists:project_pricing_tiers,id'],
            'payment_gateway' => ['required', Rule::in(['stripe', 'sslcommerz', 'bkash', 'manual'])],
        ];
    }
}
