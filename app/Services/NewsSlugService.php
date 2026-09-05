<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Str;

class NewsSlugService
{
    /**
     * Suggest an automatic slug and manual alternatives for a title.
     *
     * @return array{base: string, available: bool, slug: string, suggestions: array<int, string>}
     */
    public function suggest(string $title, ?News $ignore = null): array
    {
        $base = Str::limit(Str::slug($title), 255, '');

        if ($base === '') {
            return [
                'base' => '',
                'available' => false,
                'slug' => '',
                'suggestions' => [],
            ];
        }

        if ($this->isAvailable($base, $ignore)) {
            return [
                'base' => $base,
                'available' => true,
                'slug' => $base,
                'suggestions' => [],
            ];
        }

        $suggestions = [];
        for ($suffix = 2; count($suggestions) < 3 && $suffix <= 50; $suffix++) {
            $candidate = $this->withSuffix($base, (string) $suffix);
            if ($this->isAvailable($candidate, $ignore)) {
                $suggestions[] = $candidate;
            }
        }

        foreach (['terkini', 'resmi', 'utama'] as $word) {
            if (count($suggestions) >= 3) {
                break;
            }

            $candidate = $this->withSuffix($base, $word);
            if ($this->isAvailable($candidate, $ignore) && !in_array($candidate, $suggestions, true)) {
                $suggestions[] = $candidate;
            }
        }

        return [
            'base' => $base,
            'available' => false,
            'slug' => $suggestions[0] ?? $base,
            'suggestions' => $suggestions,
        ];
    }

    private function isAvailable(string $slug, ?News $ignore): bool
    {
        return !News::query()
            ->where('slug', $slug)
            ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
            ->exists();
    }

    private function withSuffix(string $base, string $suffix): string
    {
        $separator = '-' . $suffix;
        return Str::substr($base, 0, 255 - Str::length($separator)) . $separator;
    }
}
