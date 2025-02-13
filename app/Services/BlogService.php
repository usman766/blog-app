<?php

namespace App\Services;

use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;


class BlogService
{
    /**
     * Get all blogs for the authenticated user.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllBlogs(int $perPage = 10): LengthAwarePaginator
    {
        return Blog::where('user_id',auth()->id())->paginate($perPage);
    }

    /**
     * Create a new blog for the authenticated user.
     *
     * @param array $data
     * @return Blog
     */
    public function createBlog(array $data): Blog
    {
        $data['user_id'] = auth()->id();
        return Blog::create($data);
    }

    /**
     * Update an existing blog.
     *
     * @param Blog $blog
     * @param array $data
     * @return Blog
     */
    public function updateBlog(Blog $blog, array $data): Blog
    {
        $blog->update($data);
        return $blog;
    }

    /**
     * Delete a blog by its ID.
     * @param Blog $blog
     * @return void
     */
    public function deleteBlog(Blog $blog): void
    {
        $blog->delete();
        return;
    }

    /**
     * Force delete a blog.
     *
     * @param Blog $blog
     * @return void
     */
    public function forceDeleteBlog(Blog $blog): void
    {
        $blog->forceDelete();
        return;
    }

    /**
     * Restore a soft-deleted blog.
     *
     * @param Blog $blog
     * @return void
     */
    public function restoreBlog(Blog $blog): void
    {
        $blog->restore();
        return;
    }
}
