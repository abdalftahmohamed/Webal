<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\PlanRequest;
use App\Http\Requests\api\SubscriptionRequest;
use App\Models\Plan as ModelsPlan;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\GeneralTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Stripe\Plan;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    use GeneralTrait;
    public function savePlan(PlanRequest $request)
    {
//        return $request;
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $amount = ($request->amount * 100);
        try {
            $plan = Plan::create([
                'amount' => $amount,
                'currency' => $request->currency,
                'interval' => $request->billing_period,
                'interval_count' => $request->interval_count,
                'product' => [
                    'name' => $request->name
                ]
            ]);

         $plan=ModelsPlan::create([
                'plan_id' => $plan->id,
                'name' => $request->name,
                'price' => $plan->amount,
                'billing_method' => $plan->interval,
                'currency' => $plan->currency,
                'interval_count' => $plan->interval_count
            ]);

        }
        catch(Exception $ex){
            return response()->json([
                'status' => false,
                'message' => 'Exception Error System',
                'Error' => $ex->getMessage()
            ], 502);
        }

        return response()->json([
            'status' => true,
            'message' => 'plan created successfully',
            'plan' => $plan
        ], 201);
    }

    public function showPlans(): JsonResponse
    {
        try {
            $plans = ModelsPlan::all();
            return response()->json([
                'status' => true,
                'message' => 'plan Show successfully',
                'plan' => $plans
            ], 201);

        } catch (\Throwable $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Exception Error System',
                'Error' => $ex->getMessage()
            ], 502);
        }
    }
    public function checkout(Request $request)
    {
        $plan = ModelsPlan::where('plan_id', $request->planId)->first();
        if(! $plan){
            return back()->withErrors([
                'message' => 'Unable to locate the plan'
            ]);
        }
        $user = User::find(auth()->user()->id);
        return view('stripe.plans.checkout', [
            'plan' => $plan,
            'intent' => $user->createSetupIntent()
        ]);
    }

    public function proccessCheckout(Request $request)
    {
        try {
//            return $request;
            $user = auth('api')->user();
//return $user;

            $user->createOrGetStripeCustomer();
            $paymentMethod = null;
            $paymentMethod = $request->payment_method;
            if($paymentMethod != null){
                $paymentMethod = $user->addPaymentMethod($paymentMethod);
            }
            $plan = $request->plan_id;
                $user->newSubscription(
                    'default', $plan
                )->create( $paymentMethod != null ? $paymentMethod->id: '');
        }
        catch(Exception $ex){
            return response()->json([
                'status' => false,
                'message' => 'Exception Error System Plan',
                'Error' => $ex->getMessage()
            ], 502);
        }
        return response()->json([
            'status' => true,
            'message' => 'you checkoutPlan successfully',
        ], 201);

    }

    public function allSubscriptions()
    {
        if (auth('api')->user()->onTrial('default')) {
            dd('trial');
        }
        $subscriptions = \Laravel\Cashier\Subscription::where('user_id', auth('api')->id())->get();
        return response()->json([
            'status' => true,
            'message' => 'you checkoutPlan successfully',
            'subscriptions' =>$subscriptions ,
        ], 201);
    }
    public function singleCharge(Request $request)
    {
        try {
            $amount = ($request->amount * 100);
            $paymentMethod=$request->payment_method;
            $user= auth()->user();

            $user->createOrGetStripeCustomer();
            $paymentMethod=$user->addPaymentMethod($paymentMethod);

            $user->charge($amount,$paymentMethod->id);
            return redirect()->back();
        }
        catch (Exception $exception){
            return redirect()->back();
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
            return response()->json([
                'status' => false,
                'message' => 'Exception Error System',
                'Error' => $ex->getMessage()
            ], 502);
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





    public function subscribe(Request $request)
    {
        try {
            // Add the Stripe library and set your Stripe secret key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Get the necessary data from the request
            $paymentMethod = $request->input('payment_method');
            $planId = $request->input('plan_id');

            // Create a customer and subscribe them to the plan
            $customer = \Stripe\Customer::create([
                'payment_method' => $paymentMethod,
                'email' => $request->user()->email, // assuming you have a user model
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod,
                ],
            ]);

            $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [['plan' => $planId]],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Return the subscription details to the client
            return response()->json($subscription);
        } catch (CardException $e) {
            // Handle Stripe card errors and return an error response
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions and return an error response
            return response()->json(['error' => 'An error occurred while subscribing'], 500);
        }
    }

    public function cancelSubscription(Request $request)
    {
        try {
            // Add the Stripe library and set your Stripe secret key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Get the necessary data from the request
            $subscriptionId = $request->input('subscription_id');

            // Cancel the subscription
            $subscription = \Stripe\Subscription::retrieve($subscriptionId);
            $subscription->cancel();

            // Return a success message to the client
            return response()->json(['message' => 'Subscription canceled successfully']);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => 'An error occurred while canceling the subscription'], 500);
        }
    }
}
