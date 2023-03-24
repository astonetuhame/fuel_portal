<?php

namespace App\Http\Livewire;

use App\Models\Truck;
use App\Models\Reason;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\NonTrip as ModelsNonTrip;

class NonTrip extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;


    protected $listeners = ['refreshParent' => '$refresh'];

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
        NonTrip::destroy($this->selectedItem);
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
        $nontrips = ModelsNonTrip::whereHas('truck', function ($q) use ($search) {
                        $q->where('truck_no', 'like', '%' . $search . '%');
                     })
                    ->latest()->paginate(50);
        

        return view('livewire.non-trip', ['nontrips' => $nontrips]);
    }
}
