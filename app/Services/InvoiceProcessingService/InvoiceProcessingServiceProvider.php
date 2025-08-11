<?php

namespace App\Services\InvoiceProcessingService;

use Illuminate\Support\ServiceProvider;

class InvoiceProcessingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(InvoiceProcessingService::class, function ($app) {
            return new InvoiceProcessingService();
        });
    }
}
