<?php

namespace App\Listeners;

use App\Events\BlogCreated;
use App\Notifications\BlogCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyBlogCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlogCreated $event): void
    {
        Notification::send($event->blog->user, new BlogCreatedNotification($event->blog));
        broadcast(new BlogCreated($event->blog));
    }
}
