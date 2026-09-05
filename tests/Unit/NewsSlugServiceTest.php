<?php

namespace Tests\Unit;

use App\Models\News;
use App\Models\User;
use App\Services\NewsSlugService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsSlugServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_the_base_slug_when_available(): void
    {
        $result = app(NewsSlugService::class)->suggest('Ini Adalah Berita');

        $this->assertSame('ini-adalah-berita', $result['base']);
        $this->assertTrue($result['available']);
        $this->assertSame('ini-adalah-berita', $result['slug']);
        $this->assertSame([], $result['suggestions']);
    }

    public function test_it_returns_a_unique_suffix_and_three_recommendations_for_a_duplicate(): void
    {
        $this->createNews('ini-adalah-berita');
        $this->createNews('ini-adalah-berita-2');

        $result = app(NewsSlugService::class)->suggest('Ini Adalah Berita');

        $this->assertFalse($result['available']);
        $this->assertSame('ini-adalah-berita-3', $result['slug']);
        $this->assertCount(3, $result['suggestions']);
        $this->assertSame([
            'ini-adalah-berita-3',
            'ini-adalah-berita-4',
            'ini-adalah-berita-5',
        ], $result['suggestions']);
    }

    public function test_it_ignores_the_current_news_record(): void
    {
        $news = $this->createNews('berita-lama');

        $result = app(NewsSlugService::class)->suggest('Berita Lama', $news);

        $this->assertTrue($result['available']);
        $this->assertSame('berita-lama', $result['slug']);
    }

    public function test_it_returns_empty_values_for_a_title_without_slug_text(): void
    {
        $result = app(NewsSlugService::class)->suggest('---');

        $this->assertSame('', $result['base']);
        $this->assertSame('', $result['slug']);
        $this->assertSame([], $result['suggestions']);
    }

    private function createNews(string $slug): News
    {
        return News::query()->create([
            'title' => str_replace('-', ' ', $slug),
            'slug' => $slug,
            'content' => 'Test content',
            'author_id' => User::factory()->create()->id,
            'status' => 'draft',
        ]);
    }
}
