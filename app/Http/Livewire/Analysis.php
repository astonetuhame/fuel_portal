<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Livewire\Component;
use App\Exports\LpoExport;
use Livewire\WithPagination;

class Analysis extends Component
{

    use WithPagination;

    public $search = '';


    protected $paginationTheme = 'bootstrap';

    public $selectedRows = [];
    public $selectPageRows = false;

    public function updatedSelectPageRows($value)
    {
        $search = $this->search;

        $expenses = Expense::whereHas('lpo.station',  function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        })->orwhereHas('lpo.loadings.truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->where('generated', 1)->get();

        if ($value) {
            $this->selectedRows = $expenses->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function export()
    {
        return (new LpoExport($this->selectedRows))->download('analysis.xls');
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
        $expenses = Expense::whereHas('lpo.station', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('date', 'like', '%' . $search . '%');
        })->orwhereHas('lpo.loadings.truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->latest()->paginate(50);

        return view('livewire.analysis', compact('expenses'));
    }
}