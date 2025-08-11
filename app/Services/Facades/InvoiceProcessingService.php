<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class InvoiceProcessingService extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\InvoiceProcessingService\InvoiceProcessingService::class;
    }
}
