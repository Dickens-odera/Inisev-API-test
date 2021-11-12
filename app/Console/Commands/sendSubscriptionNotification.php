<?php

namespace App\Console\Commands;

use App\Models\Website;
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
    public function handle(): void
    {
        $postData = [];
        $websites = Website::with('posts','subscribers')->where(function(Builder $query){
            $query->where('domain',$this->argument('website'));
        })->get()->filter(function($website){
            return $website->domain !== null;
        });

        foreach ($websites as $website){
            foreach($website->posts as $post){
                $postData[] = [
                    'title' => $post->title,
                    'description' => $post->description
                ];
            }
            foreach($website->subscribers as $subscriber){
                $data = array_merge($postData,['name' => $subscriber->first_name]);
                if($subscriber->notify(new NewPostPublished($data))){
                    $this->info('Notifications sent successfully');
                }else{
                    $this->info('Failed to send notification');
                }
            }
        }
    }
}
