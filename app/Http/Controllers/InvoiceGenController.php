<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceGenController extends Controller
{
    public function invoice()
    {
        $test = "test";

        $client = new Party([
            'name'          => 'Sibed Company Limited(2022) - From 1st Jan 2022)',
            // 'phone'         => '(520) 318-9486',
            // 'custom_fields' => [
            //     'note'        => 'IDDQD',
                // 'business id' => '365#GG',
            // ],
        ]);

        $customer = new Party([
            // 'name'          => 'Africa Fuels & Lubricants Ltd',
            'name'          => $test,
            // 'address'       => 'The Green Street 12',
            // 'code'          => '#22663214',
            // 'custom_fields' => [
            //     'order number' => '> 654321 <',
            // ],
        ]);

        $items = [
            (new InvoiceItem())->pricePerUnit(148.81)->quantity(280),
  
        ];

        // $notes = [
        //     'your multiline',
        //     'additional notes',
        //     'in regards of delivery or something else',
        // ];
        // $notes = implode("<br>", $notes);

        $invoice = Invoice::make('PURCHASE ORDER')
            ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('d/m/Y')
            ->payUntilDays(14)
            ->currencySymbol('Ksh')
            ->currencyCode('KES')
            // ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            // ->notes($notes)
            ->logo(public_path('sibed.png'))
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        return $invoice->stream();
    }
}
