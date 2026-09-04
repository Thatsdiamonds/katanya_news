<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $request, News $news)
    {
        if ($request->user()->role !== 'superadmin') {
            abort(403);
        }

        $validated = $request->validate([
            'action' => 'required|in:approve,publish,revise',
            'rejection_reason' => 'required_if:action,revise|nullable|string',
        ]);

        if ($validated['action'] === 'approve') {
            $news->update(['status' => 'approved', 'rejection_reason' => null]);
            $message = 'Article approved successfully.';
        } elseif ($validated['action'] === 'publish') {
            $news->update([
                'status' => 'published',
                'published_at' => now(),
                'rejection_reason' => null
            ]);
            $message = 'Article published successfully.';
        } elseif ($validated['action'] === 'revise') {
            $news->update([
                'status' => 'revision',
                'rejection_reason' => $validated['rejection_reason']
            ]);
            $message = 'Article sent back for revision.';
        }

        return redirect()->route('admin.news.index')->with('success', $message);
    }
}
