<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Local as ModelsLocal;

class Local extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;


    protected $listeners = ['refreshParent' => '$refresh'];

    public function selectItem($localID, $action)
    {
        $this->selectedItem = $localID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getLocalID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        ModelsLocal::destroy($this->selectedItem);
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
        $locals = ModelsLocal::whereHas('truck', function ($q) use ($search) {
            $q->where('truck_no', 'like', '%' . $search . '%');
        })->paginate(20);
        return view('livewire.local', compact('locals'));
    }
}
