<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use App\Models\Loading;
use Livewire\Component;
use App\Exports\ReportExport;
use Livewire\WithPagination;

class Report extends Component
{
    use WithPagination;

    public $search = '';


    protected $paginationTheme = 'bootstrap';

    public $selectedRows = [];
    public $selectPageRows = false;

    public function updatedSelectPageRows($value)
    {
        $search = $this->search;

        $loadings = Loading::whereHas('truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->orwhereHas('route', function ($q) use ($search) {
            $q->where('route_name', 'like', '%' . $search . '%');
        })->get();

        if ($value) {
            $this->selectedRows = $loadings->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function export()
    {
        return (new ReportExport($this->selectedRows))->download('report.xls');
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        $search = $this->search;

        $loadings = Loading::groupBy('id')->with('truck', 'route', 'lpos')->whereHas('truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->orwhereHas('route', function ($q) use ($search) {
            $q->where('route_name', 'like', '%' . $search . '%');
        })->latest()->paginate(50);

        return view('livewire.report', compact('loadings'));
    }
}
