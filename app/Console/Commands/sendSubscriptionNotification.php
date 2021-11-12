<?php

namespace App\Console\Commands;

use App\Events\PostPublished;
use App\Models\Post;
use App\Models\Website;
use App\Notifications\NewPostPublished;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

class sendSubscriptionNotification extends Command
{
    public $subscriber;
    public $post;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribers:mail {website} {--queue}';

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
     * @return void
     */
    public function handle()
    {
        $websites =  Website::with('subscribers','posts')->where('domain',$this->argument('website'))->get();
        foreach ($websites as $website){
            $posts = Post::where(function(Builder $query) use($website){
                $query->where('website_id', $website->first()->id);
            })->get();
            foreach($posts as $post){
                PostPublished::dispatch($website, $post);
            }
        }
    }
}
