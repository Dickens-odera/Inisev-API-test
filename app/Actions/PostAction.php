<?php


namespace App\Actions;


use App\Events\PostPublished;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use App\Notifications\NewPostPublished;
use App\Traits\CommonApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Support\Facades\Log;

class PostAction
{
    use CommonApiResponse;

    /**
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        try{
            $newPost = Post::create(array_merge($request->validated(),['slug' => Str::slug($request->title,'-')]));
            $subscribers = Subscriber::where(function(Builder $query) use($newPost){
                $query->where('website_id',$newPost->website_id);
            });
            foreach ($subscribers as $subscriber){
                $website = Website::where(function (Builder $query) use($subscriber){
                    $query->where('id',$subscriber->website_id);
                })->first();
                PostPublished::dispatch($website, $newPost);
            }
            return $this->commonApiResponse(true,'Post Created Successfully',new PostResource($newPost),Response::HTTP_CREATED);
        }catch (QueryException $queryException){
            Log::critical('Failed to create new post: ERROR: '.$queryException->errorInfo[2]);
            return $this->commonApiResponse(false,'Something went wrong creating new post','', Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (Exception $exception){
            Log::critical('Failed to create post: ERROR: '.$exception->getTraceAsString());
            return $this->commonApiResponse(false,'Something went wrong creating post','', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
