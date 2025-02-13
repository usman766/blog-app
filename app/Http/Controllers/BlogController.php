<?php

namespace App\Http\Controllers;

use App\Events\BlogCreated;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\StoreBlogRequest;
use App\Services\BlogService;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class BlogController extends Controller
{
    public function __construct(private BlogService $blogService) {}

    /**
     * Store a newly created blog in storage.
     *
     * @param StoreBlogRequest $request
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        try {

            $blog = $this->blogService->createBlog(data: $request->validated());
            // event(new BlogCreated($blog));
            return jsonResponse(
                message: __('messages.blog.created'),
                data: new BlogResource($blog),
                statusCode: 201
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.create_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Display a listing of blogs.
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $perPage = $request->get(key: 'per_page', default: 10);
            $blogs = $this->blogService->getAllBlogs(perPage: $perPage);
            return BlogResource::collection(resource: $blogs);
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.retrieve_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Display the specified blog.
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function show(Blog $blog): JsonResponse
    {
        try {

            if($blog->user_id !== auth()->id()) {
                return jsonResponse(
                    message: __('messages.blog.unauthorized'),
                    statusCode: 403
                );
            }

            return jsonResponse(
                message: __('messages.blog.retrieved'),
                data: new BlogResource($blog),
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.retrieve_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Update the specified blog in storage.
     *
     * @param Request $request
     * @param Blog $blog
     * @return JsonResponse
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        try {
            $blog = $this->blogService->updateBlog(blog: $blog, data: $request->all());
            return jsonResponse(
                message: __('messages.blog.updated'),
                data: new BlogResource($blog),
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.update_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function destroy(Blog $blog): JsonResponse
    {
        try {
            $this->blogService->deleteBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.deleted'),
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.delete_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Force delete a blog.
     *
     * @param Blog $blog
     * @return JsonResponse
     */
    public function forceDelete(Blog $blog): JsonResponse
    {
        try {
            $this->blogService->forceDeleteBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.permanently_deleted'),
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.delete_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }

    /**
     * Restore a soft-deleted blog.
     *
     * @param int $blogID
     * @return JsonResponse
     */
    public function restore(int $blogID): JsonResponse
    {
        try {
            $blog = Blog::onlyTrashed()->findOrFail(id: $blogID);
            $this->blogService->restoreBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.restored'),
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.restore_failed', ['error' => $e->getMessage()]),
                statusCode: 500
            );
        }
    }
}
