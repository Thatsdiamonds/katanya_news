<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsSlugEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_writer_can_request_slug_suggestions(): void
    {
        $user = User::factory()->create(['role' => 'writer']);

        $response = $this->actingAs($user)->getJson(route('admin.news.slug-suggestions', [
            'title' => 'Berita Baru Hari Ini',
        ]));

        $response->assertOk()->assertJson([
            'base' => 'berita-baru-hari-ini',
            'available' => true,
            'slug' => 'berita-baru-hari-ini',
            'suggestions' => [],
        ]);
    }

    public function test_a_writer_cannot_request_suggestions_for_another_writers_news(): void
    {
        $owner = User::factory()->create(['role' => 'writer']);
        $otherWriter = User::factory()->create(['role' => 'writer']);
        $news = News::query()->create([
            'title' => 'Berita Lama',
            'slug' => 'berita-lama',
            'content' => 'Content',
            'author_id' => $owner->id,
            'status' => 'draft',
        ]);

        $response = $this->actingAs($otherWriter)->getJson(route('admin.news.slug-suggestions', [
            'title' => 'Berita Baru',
            'ignore' => $news->id,
        ]));

        $response->assertForbidden();
    }
}
