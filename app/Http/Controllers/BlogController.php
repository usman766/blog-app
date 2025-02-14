<?php

namespace App\Http\Controllers;

use App\Events\BlogCreated;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreBlogRequest;
use App\Services\BlogService;
use App\Models\Blog;
use App\Http\Resources\BlogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Exception;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    /**
     * Store a newly created blog in storage.
     * @param StoreBlogRequest $request
     * @return JsonResponse
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        return handleRequest(function () use ($request) {
            $blog = $this->blogService->createBlog($request->validated());

            event(new BlogCreated($blog));

            return jsonResponse(__('messages.blog.created'), new BlogResource($blog), 201);
        });
    }

    /**
     * Display a listing of blogs.
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        return handleRequest(function () use ($request) {
            $perPage = $request->get('per_page', 10);
            $blogs = $this->blogService->getAllBlogs($perPage);

            return BlogResource::collection($blogs);
        });
    }

    /**
     * Display the specified blog.
     * @param Blog $blog
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
    {
        return handleRequest(function () use ($blog) {
            Gate::authorize('view', $blog);

            return jsonResponse(__('messages.blog.retrieved'), new BlogResource($blog));
        });
    }

    /**
     * Update the specified blog.
     * @param Request $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        return handleRequest(function () use ($request, $blog) {
            Gate::authorize('update', $blog);

            $blog = $this->blogService->updateBlog($blog, $request->all());

            return jsonResponse(__('messages.blog.updated'), new BlogResource($blog));
        });
    }

    /**
     * Remove the specified blog.
     * @param Blog $blog
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        return handleRequest(function () use ($blog) {
            Gate::authorize('delete', $blog);

            $this->blogService->deleteBlog($blog);

            return jsonResponse(__('messages.blog.deleted'));
        });
    }

    /**
     * Force delete a blog.
     * @param Blog $blog
     * @return JsonResponse
     */
    public function forceDelete(Blog $blog): JsonResponse
    {
        return handleRequest(function () use ($blog) {
            Gate::authorize('forceDelete', $blog);

            $this->blogService->forceDeleteBlog($blog);

            return jsonResponse(__('messages.blog.permanently_deleted'));
        });
    }

    /**
     * Restore a soft-deleted blog.
     * @param int $blogID
     * @return JsonResponse
     */
    public function restore(int $blogID): JsonResponse
    {
        return handleRequest(function () use ($blogID) {
            $blog = Blog::onlyTrashed()->findOrFail($blogID);

            Gate::authorize('restore', $blog);

            $this->blogService->restoreBlog($blog);

            return jsonResponse(__('messages.blog.restored'));
        });
    }
}
