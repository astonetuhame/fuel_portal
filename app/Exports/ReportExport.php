<?php

namespace App\Exports;

use App\Models\Loading;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportExport implements FromView, ShouldAutoSize
{
        use Exportable;

        protected $selectedRows;

        public function __construct($selectedRows)
        {
            $this->selectedRows = $selectedRows;
        }
    

        public function view(): View
        {
            return view('report-table', [
                'loadings' => Loading::whereIn('id', $this->selectedRows)->groupBy('id')->with('truck', 'route', 'lpos')->get()
            ]);
        }

}
