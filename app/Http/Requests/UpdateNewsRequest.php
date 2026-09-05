<?php

namespace App\Http\Requests;

use App\Services\NewsSlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $news = $this->route('news');
        return $this->user()->can('update', $news);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $news = $this->route('news');
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('news', 'slug')->ignore($news->id)],
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
        $news = $this->route('news');

        if (! $news || $this->boolean('slug_manual') || ! $this->filled('title')) {
            return;
        }

        if (! $this->boolean('slug_change_confirmed') && $this->string('title')->toString() !== $news->title) {
            $this->merge(['slug' => $news->slug]);
            return;
        }

        if ($this->boolean('slug_change_confirmed') && $this->string('title')->toString() !== $news->title) {
            $suggestion = app(NewsSlugService::class)->suggest($this->string('title')->toString(), $news);
            $this->merge(['slug' => $suggestion['slug']]);
        }
    }
}
