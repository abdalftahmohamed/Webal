<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Plan;

class SubscriptionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function retrievePlans() {
        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $plansraw = $stripe->plans->all();
        $plans = $plansraw->data;

        foreach($plans as $plan) {
            $prod = $stripe->products->retrieve(
                $plan->product,[]
            );
            $plan->product = $prod;
        }
        return $plans;
    }
    public function showSubscription() {
        $plans = $this->retrievePlans();
        $user = Auth::user();

        return view('seller.pages.subscribe', [
            'user'=>$user,
            'intent' => $user->createSetupIntent(),
            'plans' => $plans
        ]);
    }
    public function processSubscription(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        $plan = $request->input('plan');
        try {
            $user->newSubscription('default', $plan)->create($paymentMethod, [
                'email' => $user->email
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }

        return redirect('dashboard');
    }
    public function singleCharge(Request $request)
    {
//        return $request->all();
        $amount = ($request->amount * 100);
        $paymentMethod=$request->payment_method;
        $user= auth()->user();
        $user->createOrGetStripeCustomer();
        $paymentMethod=$user->addPaymentMethod($paymentMethod);

        $user->charge($amount,$paymentMethod->id);
        return redirect()->back();
    }

    public function showPlanForm(){
        return view('stripe.plans.create');
    }
    public function savePlan(Request $request){
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $amount = ($request->amount * 100);
        try {
            $plan= Plan::create([
                'amount'=>$amount,
                'currency'=>$request->currency,
                'interval'=>$request->billing_period,
                'interval_count'=>$request->interval_count,
                'product'=>[
                    'name'=>$request->name,
                ]
            ]);
//            return $plan;
            \App\Models\Plan::create([
                'plan_id'=>$plan->id,
                'name'=>$request->name,
                'billing_method'=>$plan->interval,
                'price'=>$plan->amount,
                'currency'=>$plan->currency,
                'interval_count'=>$plan->interval_count,

            ]);

        }catch (\Exception $ex){
            dd($ex->getMessage());
        }
        return 'success';

    }
}
