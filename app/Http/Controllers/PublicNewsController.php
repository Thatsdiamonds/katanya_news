<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with(['author', 'category'])
            ->where('status', 'published')
            ->latest('published_at');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->input('category') !== '') {
            $catFilter = $request->input('category');
            $query->whereHas('category', function ($q) use ($catFilter) {
                $q->where('slug', $catFilter)
                  ->orWhere('name', $catFilter);
            });
        }

        $news = $query->paginate(16)->withQueryString();
        
        $categories = Category::withCount(['news' => function ($q) {
                $q->where('status', 'published');
            }])
            ->orderByDesc('news_count')
            ->get();

        // Get latest news related to Technology
        $technologyNews = News::with(['author', 'category'])
            ->where('status', 'published')
            ->whereHas('category', function ($q) {
                $q->where('slug', 'like', '%teknologi%')
                  ->orWhere('name', 'like', '%teknologi%')
                  ->orWhere('slug', 'like', '%tech%')
                  ->orWhere('name', 'like', '%tech%');
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        // Top categories with most published news
        $topCategories = Category::withCount(['news' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get()
            ->filter(fn ($cat) => $cat->news_count > 0)
            ->sortByDesc('news_count')
            ->take(6);

        if ($topCategories->isEmpty()) {
            $topCategories = $categories->take(6);
        }

        // Top authors
        $topAuthors = \App\Models\User::whereHas('news', function($q) {
            $q->where('status', 'published');
        })->withCount(['news' => function($q) {
            $q->where('status', 'published');
        }])->orderByDesc('news_count')->take(5)->get();

        // Curated news for Sorotan Redaksi section
        $editorPicks = News::with(['author', 'category'])
            ->where('status', 'published')
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Trending by Category - Top 4 categories with their most viewed articles (last 7 days)
        $trendingByCategory = Category::withCount(['news' => function ($q) {
                $q->where('status', 'published');
            }])
            ->whereHas('news', function ($q) {
                $q->where('status', 'published');
            })
            ->orderByDesc('news_count')
            ->take(4)
            ->get()
            ->map(function ($category) {
                $trendingArticles = News::with(['author', 'category'])
                    ->where('status', 'published')
                    ->where('category_id', $category->id)
                    ->where('published_at', '>=', now()->subDays(7))
                    ->orderByDesc('views')
                    ->take(3)
                    ->get();

                // Fallback to latest if not enough trending
                if ($trendingArticles->count() < 3) {
                    $fallback = News::with(['author', 'category'])
                        ->where('status', 'published')
                        ->where('category_id', $category->id)
                        ->whereNotIn('id', $trendingArticles->pluck('id'))
                        ->latest('published_at')
                        ->take(3 - $trendingArticles->count())
                        ->get();
                    $trendingArticles = $trendingArticles->concat($fallback);
                }

                return [
                    'category' => $category,
                    'articles' => $trendingArticles,
                ];
            })
            ->filter(fn($item) => $item['articles']->isNotEmpty());

        // Articles pool for preference-based recommendations
        $categoryNewsPool = News::with(['author', 'category'])
            ->where('status', 'published')
            ->latest('published_at')
            ->take(50)
            ->get()
            ->map(function ($item) {
                $now = now();
                $diffSec = $item->published_at ? $item->published_at->diffInSeconds($now) : 0;
                $diffMin = $item->published_at ? $item->published_at->diffInMinutes($now) : 0;
                $diffHour = $item->published_at ? $item->published_at->diffInHours($now) : 0;
                $diffDay = $item->published_at ? $item->published_at->diffInDays($now) : 0;
                $diffWeek = $item->published_at ? $item->published_at->diffInWeeks($now) : 0;
                $diffMonth = $item->published_at ? $item->published_at->diffInMonths($now) : 0;
                $diffYear = $item->published_at ? $item->published_at->diffInYears($now) : 0;

                if ($diffSec < 60) {
                    $timeAgo = $diffSec . ' detik lalu';
                } elseif ($diffMin < 60) {
                    $timeAgo = $diffMin . ' menit lalu';
                } elseif ($diffHour < 24) {
                    $timeAgo = $diffHour . ' jam lalu';
                } elseif ($diffDay < 7) {
                    $timeAgo = $diffDay . ' hari lalu';
                } elseif ($diffWeek < 4) {
                    $timeAgo = $diffWeek . ' minggu lalu';
                } elseif ($diffMonth < 12) {
                    $timeAgo = $diffMonth . ' bulan lalu';
                } else {
                    $timeAgo = $diffYear . ' tahun lalu';
                }

                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'url' => route('news.show', $item->slug),
                    'category_name' => $item->category ? $item->category->name : '',
                    'category_slug' => $item->category ? $item->category->slug : '',
                    'category_url' => $item->category ? route('home', ['category' => $item->category->slug]) : '#',
                    'image' => $item->image ? \Illuminate\Support\Facades\Storage::url($item->image) : null,
                    'author' => $item->author ? $item->author->name : 'Redaksi',
                    'time_ago' => $timeAgo,
                    'exact_date' => $item->published_at ? $item->published_at->locale('id')->translatedFormat('d F Y, H:i') : '',
                    'is_outside_recent' => $diffDay >= 7,
                ];
            });

        return view('public.home', compact('news', 'categories', 'technologyNews', 'topCategories', 'topAuthors', 'editorPicks', 'categoryNewsPool', 'trendingByCategory'));
    }

    public function show(News $news)
    {
        $canPreview = auth()->check() && (auth()->user()->role === 'superadmin' || auth()->id() === $news->author_id);

        if ($news->status !== 'published' && !$canPreview) {
            abort(404);
        }

        // Increment views with session-based throttle
        $news->incrementViews();

        $news->load(['author', 'category']);

        $categories = Category::orderBy('name')->get();

        // Related news from the same category or latest published news (excluding current)
        $relatedNews = News::with(['author', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', $news->id)
            ->when($news->category_id, function ($q) use ($news) {
                $q->where('category_id', $news->category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        // Fallback if not enough related in the same category
        if ($relatedNews->count() < 3) {
            $extra = News::with(['author', 'category'])
                ->where('status', 'published')
                ->where('id', '!=', $news->id)
                ->whereNotIn('id', $relatedNews->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedNews->count())
                ->get();
            $relatedNews = $relatedNews->concat($extra);
        }

        return view('public.news.show', compact('news', 'categories', 'relatedNews'));
    }

    /**
     * Search hints API endpoint for autocomplete
     */
    public function searchHints(Request $request)
    {
        $request->validate([
            'query' => ['required', 'string', 'min:3', 'max:255'],
        ]);

        $query = $request->string('query')->toString();

        // Handle random placeholder request
        if ($query === 'random') {
            $suggestions = News::where('status', 'published')
                ->with('category')
                ->select('id', 'title', 'slug', 'category_id', 'views', 'image')
                ->inRandomOrder()
                ->take(5)
                ->get();
        } else {
            $suggestions = News::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%");
                })
                ->with('category')
                ->select('id', 'title', 'slug', 'category_id', 'views', 'image')
                ->orderByDesc('views')
                ->take(8)
                ->get();
        }

        $results = $suggestions->map(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'slug' => $news->slug,
                'category_name' => $news->category ? $news->category->name : '',
                'views' => $news->formatted_views,
                'url' => route('news.show', $news->slug),
                'image' => $news->image ? \Illuminate\Support\Facades\Storage::url($news->image) : null,
            ];
        });

        return response()->json($results);
    }
}
