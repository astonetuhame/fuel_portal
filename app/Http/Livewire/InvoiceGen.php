<?php

namespace App\Http\Livewire;

use App\Models\Lpo;
use App\Models\Expense;
use App\Models\Station;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceGen extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedRows = [];
    public $search;

    public $selectPageRows = false;


    public function updatedSelectPageRows($value)
    {
        $expenses = Expense::with('lpo')->where('generated', 0)->get();
        if ($value) {
            $this->selectedRows = $expenses->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }


    public function invoice()
    {
        $station = [];
        $currency = [];
        $quantity = [];
        $lpo_ids = [];

        $prints = Expense::whereIn('id', $this->selectedRows)->with('lpo')->get();
        foreach ($prints as $invoiceItem) {
            array_push($station, $invoiceItem->lpo->station['name']);
        }


        foreach ($prints as $invoiceItem) {
            array_push($currency, $invoiceItem->lpo->station['currency']);
        }

        foreach ($prints as $invoiceItem) {
            array_push($lpo_ids, $invoiceItem->lpo_id);
        }


        if (count(array_unique($station)) == 1) {
            $client = new Party([
                'name'          => 'Sibed Transport Company Limited',
            ]);

            $seller = new Party([
                'name'          => $station[0],
            ]);

            $items = [];

            foreach ($prints as $invoiceItem) {
                foreach ($invoiceItem->lpo->loadings as $asset)
                    array_push(
                        $items,
                        (new InvoiceItem())->trip($asset->id)->description($asset->route['route_code'])->title($asset->truck['truck_no'])->pricePerUnit($invoiceItem->lpo->station['rate'])->quantity($invoiceItem->lpo->quantity),
                    );
            }

            $lastInvoiceID = Expense::orderBy('doc_num', 'desc')->pluck('doc_num')->first();
            $newInvoiceID = $lastInvoiceID + 1;

            $invoice = Invoice::make('PURCHASE ORDER')
                ->series('BIG')
                ->status(__('invoices::invoice.paid'))
                ->sequence($newInvoiceID)
                ->serialNumberFormat('{SEQUENCE}')
                ->seller($client)
                ->buyer($seller)
                ->date(now())
                ->dateFormat('d/m/Y')
                ->payUntilDays(14)
                ->currencySymbol($currency[0])
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.')
                ->filename('LPO ' . $newInvoiceID . ' (' . $seller->name . ')')
                ->addItems($items)
                ->logo(public_path('sibed.png'))
                // You can additionally save generated invoice to configured disk
                ->save('public');

            $link = $invoice->url();

            if ($station[0] == "GARAGE NAIROBI" || $station[0] == "GARAGE MUKONO") {
                $updateStation = Station::where('name', $station[0])->first();

                foreach ($prints as $q) {
                    array_push($quantity, $q->lpo->quantity);
                }

                $updateStation->update(['quantity' =>  $updateStation->quantity - array_sum($quantity)]);
            }

            try {
                DB::beginTransaction();

                Expense::whereIn('id', $this->selectedRows)->update(["generated" => 1, "doc_path" => $link, "doc_num" => $newInvoiceID]);
                Lpo::whereIn('id', $lpo_ids)->update(["generated" => 1]);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->emit('alert', ['type' => 'warning', 'message' => $e->getMessage()]);
            }

            $this->reset(['selectedRows', 'selectPageRows']);

            return response()->streamDownload(function () use ($invoice) {
                echo $invoice->stream();
            }, 'LPO ' . $newInvoiceID . ' (' . $seller->name . ')' . '.pdf');

            $this->emit('alert', ['type' => 'success', 'message' => 'Generated successfully']);
        } else {
            $this->emit('alert', ['type' => 'warning', 'message' => 'Cannot generate LPO from different stations']);
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function render()
    {
        $expenses = Expense::with('lpo')->where('generated', 0)->paginate(50);

        return view('livewire.invoice-gen', compact('expenses'));
    }
}
