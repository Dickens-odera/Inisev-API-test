<?php

namespace App\Http\Controllers;

use App\Actions\PostAction;
use App\Http\Requests\PostRequest;
use Illuminate\Http\JsonResponse;

/**
 * Class PostController
 * @package App\Http\Controllers
 * @group Posts
 */
class PostController extends Controller
{
    /**
     * Publish Post
     *
     * @param PostRequest $request
     * @param PostAction $postAction
     * @bodyParam title string required . The Post Title
     * @bodyParam description string required . The Post Description
     * @bodyParam website_id integer required . The Website ID
     * @return JsonResponse
     */
    public function __invoke(PostRequest $request, PostAction $postAction): JsonResponse
    {
        return $postAction->store($request);
    }
}
