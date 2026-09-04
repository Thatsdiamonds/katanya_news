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

        return view('public.home', compact('news', 'categories', 'technologyNews', 'topCategories', 'topAuthors', 'editorPicks', 'categoryNewsPool'));
    }

    public function show(News $news)
    {
        $canPreview = auth()->check() && (auth()->user()->role === 'superadmin' || auth()->id() === $news->author_id);
        
        if ($news->status !== 'published' && !$canPreview) {
            abort(404);
        }

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
}
