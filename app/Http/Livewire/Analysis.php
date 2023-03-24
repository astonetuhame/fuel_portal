<?php

namespace App\Http\Livewire;

use App\Models\Expense;
use Livewire\Component;
use App\Exports\LpoExport;
use App\Models\Loading;
use App\Models\Lpo;
use App\Models\Station;
use App\Models\Truck;
use Livewire\WithPagination;

class Analysis extends Component
{

    use WithPagination;

    public $search = '';


    protected $paginationTheme = 'bootstrap';

    public $selectedRows = [];
    public $selectPageRows = false;
    public $sortAsc = false;
    public $sortField = "id";

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }


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
        $expenses = Expense::addSelect([
            'lpo_date' => Lpo::select('date')->whereColumn('id', 'expenses.lpo_id')->take(1),
            'lpo_quantity' => Lpo::select('quantity')->whereColumn('id', 'expenses.lpo_id')->take(1),
            'lpo_rate' => Lpo::select('rate')->whereColumn('id', 'expenses.lpo_id')->take(1),
            'cost' => Lpo::selectRaw('(quantity * rate) as cost')->whereColumn('id', 'expenses.lpo_id')->take(1),

        ])
        // ->with(['lpo.loadings' => function($q){
        //     $q->select('id')->where('id', 'expenses.lpo_id');
        // }])
        ->whereHas('lpo.station', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('date', 'like', '%' . $search . '%');
        })->orwhereHas('lpo.loadings.truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->latest()->paginate(50);

        return view('livewire.analysis', compact('expenses'));
    }
}
