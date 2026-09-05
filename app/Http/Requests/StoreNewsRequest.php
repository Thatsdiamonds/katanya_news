<?php

namespace App\Http\Requests;

use App\Services\NewsSlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\News::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('news', 'slug')],
            'slug_manual' => ['nullable', 'boolean'],
            'slug_change_confirmed' => ['nullable', 'boolean'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->boolean('slug_manual') && $this->filled('title')) {
            $suggestion = app(NewsSlugService::class)->suggest($this->string('title')->toString());
            $this->merge(['slug' => $suggestion['slug']]);
        }
    }
}
