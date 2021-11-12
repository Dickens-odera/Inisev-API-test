<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Subscriber;
use App\Notifications\NewPostPublished;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class sendSubscriptionNotification extends Command
{
    public $subscriber;
    public $post;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:mail {subscriber} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send website subscribers notifications of newly created publications';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Subscriber $subscriber
     * @param Post $post
     * @return void
     */
    public function handle(Subscriber $subscriber, Post $post): void
    {
        $postData = [
            'name' => $subscriber->first_name,
            'title' => $post->title,
            'description' => $post->description
        ];

        $subscriber->notify(new NewPostPublished($postData));
        $this->info('Notification sent successfully');
    }
}
