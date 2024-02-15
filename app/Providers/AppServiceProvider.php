<?php

namespace App\Providers;

use App\Models\Contribution;
use App\Models\Investment;
use App\Models\Loan;
use App\Observers\ContributionObserver;
use App\Observers\InvestmentObserver;
use App\Observers\LoanObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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

        if($this->app->environment('production')){
            Url::forceScheme('https');
        }else{
            Url::forceScheme('http');
        }
        Schema::defaultStringLength(191);

        Contribution::observe(ContributionObserver::class);
        Loan::observe(LoanObserver::class);
        Investment::observe(InvestmentObserver::class);
    }
}
