<?php

namespace App\Services\InvoiceService;

use Illuminate\Http\Response;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceService
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function createInvoiceAsPdf(): string
    {
        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(2)
            ->addItem($item);

        $invoice->setCustomData([
            'order_id' => $orderId = random_int(100000,999999),
            'qr_data'  => base64_encode(QrCode::format('png')->size(100)->generate($orderId)),
        ]);

        return $invoice->render()->output;
    }
}
