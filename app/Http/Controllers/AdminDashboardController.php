<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $query = News::query();
        if ($user->role === 'writer') {
            $query->where('author_id', $user->id);
        }

        $stats = [
            'total' => (clone $query)->count(),
            'draft' => (clone $query)->where('status', 'draft')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'revision' => (clone $query)->where('status', 'revision')->count(),
            'published' => (clone $query)->where('status', 'published')->count(),
        ];

        $recentNews = $query->with('author')->latest('updated_at')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentNews'));
    }
}
