<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Blog;
use App\Models\User;
use App\Services\BlogService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogServiceTest extends TestCase
{
    use RefreshDatabase;

    private BlogService $blogService;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blogService = new BlogService();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_can_create_a_blog()
    {
        $data = ['title' => 'Test Blog', 'content' => 'Test content'];
        $blog = $this->blogService->createBlog($data);
        $this->assertDatabaseHas('blogs', ['title' => 'Test Blog']);
        $this->assertEquals($this->user->id, $blog->user_id);
    }

    /** @test */
    public function it_can_update_a_blog()
    {
        $blog = Blog::factory()->create(['user_id' => $this->user->id]);
        $updatedData = ['title' => 'Updated Title'];
        $updatedBlog = $this->blogService->updateBlog($blog, $updatedData);
        $this->assertEquals('Updated Title', $updatedBlog->title);
    }

    /** @test */
    public function it_can_delete_a_blog()
    {
        $blog = Blog::factory()->create(['user_id' => $this->user->id]);
        $this->blogService->deleteBlog($blog);
        $this->assertSoftDeleted('blogs', ['id' => $blog->id]);
    }

    /** @test */
    public function it_can_force_delete_a_blog()
    {
        $blog = Blog::factory()->create(['user_id' => $this->user->id]);
        $this->blogService->forceDeleteBlog($blog);
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }

    /** @test */
    public function it_can_restore_a_soft_deleted_blog()
    {
        $blog = Blog::factory()->create(['user_id' => $this->user->id]);
        $blog->delete();
        $this->blogService->restoreBlog($blog);
        $this->assertDatabaseHas('blogs', ['id' => $blog->id]);
    }

    /** @test */
    public function it_can_fetch_paginated_blogs()
    {
        Blog::factory(15)->create(['user_id' => $this->user->id]);
        $blogs = $this->blogService->getAllBlogs(10);
        $this->assertEquals(10, $blogs->count());
    }
}
