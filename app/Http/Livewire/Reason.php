<?php

namespace App\Http\Livewire;

use App\Models\Reason as ModelReason;
use Livewire\Component;
use Livewire\WithPagination;

class Reason extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    
    
    protected $listeners = ['refreshParent' => '$refresh'];

    public function selectItem($reasonID, $action)
    {
        $this->selectedItem = $reasonID;
        if ($action == 'delete') 
        { 
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getReasonID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        ModelReason::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Reason Deleted Successfully']);

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $reasons = ModelReason::where('reason', 'LIKE', "%{$this->search}%")
        ->paginate(5);

        return view('livewire.reason', compact('reasons'));
    }
}
