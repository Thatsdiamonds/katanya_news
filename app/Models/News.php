<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /** @use HasFactory<\Database\Factories\NewsFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category_id',
        'status',
        'rejection_reason',
        'author_id',
        'published_at',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Increment the views count with session-based throttle
     */
    public function incrementViews()
    {
        $sessionKey = 'viewed_news_' . $this->id;

        if (!session()->has($sessionKey)) {
            $this->increment('views');
            session()->put($sessionKey, true);
        }
    }

    /**
     * Format views count for display (1.2K, 1.5M, etc.)
     */
    public function getFormattedViewsAttribute()
    {
        $views = $this->views;

        if ($views >= 1000000) {
            return round($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return round($views / 1000, 1) . 'K';
        }

        return (string) $views;
    }
}
