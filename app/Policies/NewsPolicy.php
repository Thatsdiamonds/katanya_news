<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'superadmin') {
            return true;
        }

        return null; // fall through to other policy checks
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['writer', 'superadmin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, News $news): bool
    {
        return $user->id === $news->author_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['writer', 'superadmin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        return $user->id === $news->author_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        // For MVP, writer can delete their own drafts
        if ($user->id === $news->author_id && $news->status === 'draft') {
            return true;
        }
        
        return false;
    }

    /**
     * Custom actions for approval flow
     */
    public function submit(User $user, News $news): bool
    {
        return $user->id === $news->author_id && in_array($news->status, ['draft', 'revision']);
    }

    public function review(User $user, News $news): bool
    {
        // Before block handles superadmin, but we return false to explicitly deny writers
        return false;
    }
}
