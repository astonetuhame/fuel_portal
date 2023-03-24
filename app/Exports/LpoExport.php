<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LpoExport implements FromQuery, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;


    protected $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows = $selectedRows;
    }

    public function map($expense): array
    {
        $trucks = array();
        foreach ($expense->lpo->loadings as $a) {
            $trucks[] = $a->truck->truck_no;
        }

        $routes = array();
        foreach ($expense->lpo->loadings as $b) {
            $routes[] = $b->route->route_code;
        }

        $trip_ids = array();
        foreach ($expense->lpo->loadings as $c) {
            $trip_ids[] = $c->id;
        }

        return [
            $expense->id,
            implode(" | ", $trip_ids),
            implode(" | ", $trucks),
            Carbon::parse($expense->lpo->date)->format('d-m-Y'),
            $expense->lpo->station->name,
            implode(" | ", $routes),
            $expense->lpo->quantity,
            $expense->lpo->rate,
            number_format($expense->lpo->rate * $expense->lpo->quantity, 2),
            $expense->lpo->comment->comment,
            $expense->doc_num,
        ];
    }

    public function headings(): array
    {
        return [
            'Expense ID',
            'Trip ID',
            'Truck',
            'Lpo Date',
            'Station',
            'Route',
            'Quantity',
            'Rate',
            'Cost',
            'Comment',
            'Doc No',
        ];
    }

    public function query()
    {
        return Expense::with('lpo')->whereIn('id', $this->selectedRows);
    }
}
