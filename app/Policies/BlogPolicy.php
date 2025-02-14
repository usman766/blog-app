<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    /**
     * Determine if the authenticated user can view the blog.
     */
    public function view(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny(__('messages.blog.unauthorized'));
    }

    /**
     * Determine if the authenticated user can update the blog.
     */
    public function update(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny(__('messages.blog.unauthorized'));
    }

    /**
     * Determine if the authenticated user can delete the blog.
     */
    public function delete(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny(__('messages.blog.unauthorized'));
    }

    /**
     * Determine if the authenticated user can restore the blog.
     */
    public function restore(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny(__('messages.blog.unauthorized'));
    }

    /**
     * Determine if the authenticated user can permanently delete the blog.
     */
    public function forceDelete(User $user, Blog $blog): Response
    {
        return $user->id === $blog->user_id
            ? Response::allow()
            : Response::deny(__('messages.blog.unauthorized'));
    }
}
