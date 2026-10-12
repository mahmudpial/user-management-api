<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePremiumProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $project = $this->route('project');

        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('premium_projects', 'slug')->ignore($project)],
            'summary' => ['sometimes', 'required', 'string', 'max:2000'],
            'full_description' => ['sometimes', 'required', 'string'],
            'thumbnail_url' => ['nullable', 'url', 'max:2048'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'live_demo_url' => ['nullable', 'url', 'max:2048'],
            'video_preview_url' => ['nullable', 'url', 'max:2048'],
            'tech_stack' => ['sometimes', 'required', 'array'],
            'tech_stack.*' => ['required', 'string', 'max:100'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
            'order' => ['sometimes', 'integer'],
        ];
    }
}
