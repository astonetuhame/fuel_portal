<?php

namespace App\Http\Livewire;

use App\Models\Truck;
use Livewire\Component;
use Livewire\WithPagination;

class Trucks extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    // public $perPage = 10;
    public $sortAsc = true;
    public $sortField = "truck_no";


    protected $listeners = ['refreshParent' => '$refresh'];

    public function sortBy($field)
    {
        if($this->sortField === $field){
            $this->sortAsc =! $this->sortAsc;
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
            $this->emit('getTruckID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        Truck::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Truck Deleted Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $trucks = Truck::where('truck_no', 'LIKE', "%{$this->search}%")
        ->orderBy($this->sortField, $this->sortAsc ? 'asc': 'desc')
        ->paginate(50);


        return view('livewire.trucks', ['trucks' => $trucks]);
    }
}
