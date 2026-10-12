<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePremiumProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:premium_projects,slug'],
            'summary' => ['required', 'string', 'max:2000'],
            'full_description' => ['required', 'string'],
            'thumbnail_url' => ['nullable', 'url', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'live_demo_url' => ['nullable', 'url', 'max:2048'],
            'video_preview_url' => ['nullable', 'url', 'max:2048'],
            'tech_stack' => ['required', 'array'],
            'tech_stack.*' => ['required', 'string', 'max:100'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
            'order' => ['sometimes', 'integer'],
        ];
    }
}
