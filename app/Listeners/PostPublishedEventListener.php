<?php

namespace App\Listeners;

use App\Models\Website;
use App\Notifications\NewPostPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Artisan;

class PostPublishedEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $postData = [];
        $websites = Website::with('posts', 'subscribers')->where(function (Builder $query) use ($event) {
            $query->where('domain', $event->website->domain);
        })->get()->filter(function ($website) {
            return $website->domain !== null;
        });

        foreach ($websites as $website) {
            foreach ($website->posts as $post) {
                $postData[] = [
                    'title' => $post->title,
                    'description' => $post->description
                ];
            }
            foreach ($website->subscribers as $subscriber) {
                $data = array_merge($postData, ['name' => $subscriber->first_name]);
                $subscriber->notify(new NewPostPublished($data));
            }
        }
    }
}
