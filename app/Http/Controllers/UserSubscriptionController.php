<?php

namespace App\Http\Controllers;

use App\Actions\UserSubscriptionAction;
use App\Http\Requests\UserSubscriptionRequest;
use Illuminate\Http\JsonResponse;

/**
 * User Subscription
 * Class UserSubscriptionController
 * @package App\Http\Controllers
 * @group User Subscription
 */
class UserSubscriptionController extends Controller
{
    /**
     * Subscribe A User To A Website
     *
     * @param UserSubscriptionRequest $request
     * @param UserSubscriptionAction $userSubscriptionAction
     * @bodyParam first_name string required . The First Name of the User
     * @bodyParam last_name string required . The Last Name of the User
     * @bodyParam email email required . The email address of the User
     * @bodyParam website_id integer required . The website id this user is subscribing to
     * @return JsonResponse
     */
    public function __invoke(UserSubscriptionRequest $request, UserSubscriptionAction $userSubscriptionAction): JsonResponse
    {
        return $userSubscriptionAction->subscribe($request);
    }
}
