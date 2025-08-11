<?php

namespace App\Http\Controllers;

use App\Services\Facades\InvoiceProcessingService;
use Illuminate\Http\JsonResponse;

class InvoiceProcessingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        return \response()->json([
           'code' => InvoiceProcessingService::readQrCode('public/invoice.pdf')
        ]);
    }
}
