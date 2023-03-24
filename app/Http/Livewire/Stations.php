<?php

namespace App\Http\Livewire;

use App\Models\Station;
use Livewire\Component;
use Livewire\WithPagination;

class Stations extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    // public $perPage = 10;
    public $sortAsc = true;
    public $sortField = "name";


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

    public function selectItem($stationID, $action)
    {
        $this->selectedItem = $stationID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getStationID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        Station::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Station Deleted Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $stations = Station::where('name', 'LIKE', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->latest()->paginate(50);

        return view('livewire.stations', ['stations' => $stations]);
    }
}
