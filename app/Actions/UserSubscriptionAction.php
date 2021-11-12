<?php


namespace App\Actions;


use App\Http\Requests\UserSubscriptionRequest;
use App\Http\Resources\UserSubscriptionResource;
use App\Models\Subscriber;
use App\Traits\CommonApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class UserSubscriptionAction
{
    use CommonApiResponse;

    public function subscribe(UserSubscriptionRequest $request): JsonResponse
    {
        try{
            $newSubscriber = Subscriber::create($request->validated());
            return $this->commonApiResponse(true,'User Subscription successful', new UserSubscriptionResource($newSubscriber), Response::HTTP_CREATED);
        }catch (QueryException $queryException){
            Log::critical('Failed to subscribe user to website: ERROR: '.$queryException->errorInfo[2]);
            return $this->commonApiResponse(false,'Something went wrong subscribing user to website','', Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (Exception $exception){
            Log::critical('Failed to subscribe user to website. ERROR: '.$exception->getTraceAsString());
            return $this->commonApiResponse(false,'Something went wrong, please try again','', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
