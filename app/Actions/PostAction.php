<?php


namespace App\Actions;


use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\CommonApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
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
                return $this->commonApiResponse(true,'Post Crated Successfully',new PostResource($newPost),Response::HTTP_CREATED);
        }catch (QueryException $queryException){
            Log::critical('Failed to create new post: ERROR: '.$queryException->errorInfo[2]);
            return $this->commonApiResponse(false,'Something went wrong creating new post','', Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (Exception $exception){
            Log::critical('Failed to create post: ERROR: '.$exception->getTraceAsString());
            return $this->commonApiResponse(false,'Something went wrong creating post','', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
