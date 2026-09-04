<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = News::with(['author', 'category'])->latest('updated_at');

        // Writers only see their own articles
        if ($user->role === 'writer') {
            $query->where('author_id', $user->id);
        }

        $news = $query->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(StoreNewsRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('image')) {
            $validated['image'] = \App\Services\ImageService::storeAsWebp($request->file('image'), 'news-images');
        }

        $validated['author_id'] = $request->user()->id;
        $validated['status'] = 'draft';

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Article created successfully as Draft.');
    }

    public function edit(News $news)
    {
        $categories = \App\Models\Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image && Storage::disk('public')->exists($news->image)) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = \App\Services\ImageService::storeAsWebp($request->file('image'), 'news-images');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(News $news)
    {
        if ($news->image && Storage::disk('public')->exists($news->image)) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Article deleted successfully.');
    }

    public function submit(Request $request, News $news)
    {
        if ($request->user()->cannot('submit', $news)) {
            abort(403);
        }

        $news->update(['status' => 'pending']);

        return redirect()->route('admin.news.index')->with('success', 'Article submitted for review.');
    }

    public function preview(Request $request, News $news)
    {
        // Writers can only preview their own, Superadmin can preview any
        if ($request->user()->role === 'writer' && $news->author_id !== $request->user()->id) {
            abort(403);
        }

        return view('public.news.show', compact('news'));
    }
}
