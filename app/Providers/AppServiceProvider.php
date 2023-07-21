<?php

namespace App\Providers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\SubscriptionItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Cashier::ignoreMigrations();
//        Cashier::useCustomerModel(User::class);
//        Cashier::calculateTaxes();
//        Cashier::useSubscriptionModel(Subscription::class);
//        Cashier::useSubscriptionItemModel(SubscriptionItem::class);
    }
}
