<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\SubscriptionRequest;
use App\Models\Subscription;
use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    use GeneralTrait;

    public function index(): JsonResponse
    {
        try {
            $subscriptions = Subscription::all();
            return response()->json(
                $subscriptions
            );

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(SubscriptionRequest $request): JsonResponse
    {
        try {
            $subscription = new Subscription();
            $subscription->monthly_subscription = $request->monthly_subscription;
            $subscription->weekly_subscription = $request->weekly_subscription;
            $subscription->save();

            return response()->json([
                'message' => 'Subscription created successfully',
                'client' => $subscription
//            $subscription
            ], 201);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(SubscriptionRequest $request, $id): JsonResponse
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) {
                return $this->returnError('E004', 'this Id not found');
            }
            $subscription->monthly_subscription = $request->monthly_subscription;
            $subscription->weekly_subscription = $request->weekly_subscription;
            $subscription->save();
            return response()->json([
                'message' => 'subscription Updated successfully',
                'subscription' => $subscription
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function show($id): JsonResponse
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) {
                return $this->returnError('E004', 'this Id not found');
            }
            return response()->json([
//                    'message' => 'Team Show successfully',
//                    'subscription' => $subscription
                $subscription
            ]);

        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id): JsonResponse
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) {
                return $this->returnError('E004', 'this Id not found');
            }
            $subscription->delete();
            return response()->json([
                'status' => true,
                'message' => 'Request Information deleted Successfully',
            ]);
        } catch (\Throwable $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
