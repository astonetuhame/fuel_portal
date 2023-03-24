<?php

namespace App\Http\Livewire;

use App\Models\Lpo;
use App\Models\Loading;
use Livewire\Component;
use Livewire\WithPagination;


class Fuel extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    // public $perPage = 10;
    public $sortAsc = false;
    public $sortField = "id";


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


    public function selectItem($tripID, $action)
    {
        $this->selectedItem = $tripID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getTripID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        Loading::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Deleted Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $search = $this->search;
        $fuel = Loading::withSum('lpos', 'quantity')
            ->whereHas('truck', function ($q) use ($search) {
                $q->where('truck_no', 'like', '%' . $search . '%');
            })->orWhere('loading_date', 'LIKE', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->latest()->paginate(50);

        return view('livewire.fuel', ['fuel' => $fuel]);
    }
}
