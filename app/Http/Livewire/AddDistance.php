<?php

namespace App\Http\Livewire;

use App\Models\Local;
use Livewire\Component;
use App\Models\Distance;
use Livewire\WithPagination;

class AddDistance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $action;
    public $selectedItem, $search;
    public Local $local;

    protected $listeners = ['refreshParent' => '$refresh'];

    public function selectItem($distanceID, $action)
    {
        $this->selectedItem = $distanceID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getDistanceID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }

 

    public function delete()
    {

        Distance::destroy($this->selectedItem);

        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Deleted Successfully']);
    }


    public function render()
    {
        $distances = Distance::whereHas('local', function ($q) {
            $q->where('id', $this->local->id);
        })->paginate(20);
        
        // $diff = Distance::select('odometer')->whereHas('local', function ($q) {
        //     $q->where('id', $this->local->id);
        // })->get();

        // $test = collect($diff);
        // dd($test);

        return view('livewire.add-distance', compact('distances'));
    }
}
