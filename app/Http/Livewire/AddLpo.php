<?php

namespace App\Http\Livewire;

use App\Models\Lpo;
use App\Models\Truck;
use App\Models\Expense;
use App\Models\Loading;
use App\Models\Station;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AddLpo extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $action;
    public $selectedItem, $search;
    public Loading $loading;
    public $perPage = 10;
    public $sortAsc = true;
    public $sortField = "date";

    protected $listeners = ['refreshParent' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortField = $field;
    }

    public function selectItem($lpoID, $action)
    {
        $this->selectedItem = $lpoID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getLpoID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }

    public function addExpense($expenseID)
    {
        try {
            DB::beginTransaction();
            Expense::create(['lpo_id' => $expenseID]);
            Lpo::find($expenseID)->update(['expense' => 1]);
            DB::commit();
            $this->emit('alert', ['type' => 'success', 'message' => 'Added to Expenses']);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->emit('alert', ['type' => 'warning', 'message' => $e->getMessage()]);
        }
    }

    public function delete()
    {

        Lpo::destroy($this->selectedItem);

        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Deleted Successfully']);
    }


    public function render()
    {

        $lpos = Lpo::whereHas('loadings', function ($q) {
            $q->where('loading_lpo.loading_date', $this->loading->loading_date)
                ->where('loading_lpo.loading_id', $this->loading->id);
        })
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate(5);

        return view('livewire.add-lpo', compact('lpos'));
    }
}
