<?php

namespace App\Http\Livewire;

use App\Models\Route;
use Livewire\Component;
use Livewire\WithPagination;

class Routes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $action;
    public $selectedItem;
    // public $perPage = 10;
    public $sortAsc = true;
    public $sortField = "route_code";


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

    public function selectItem($routeID, $action)
    {
        $this->selectedItem = $routeID;
        if ($action == 'delete') {
            $this->emit('openDeleteModal');
        } else {
            $this->emit('getRouteID', $this->selectedItem);
            $this->emit('openFormModal');
        }
    }


    public function delete()
    {
        Route::destroy($this->selectedItem);
        $this->emit('closeDeleteModal');
        $this->emit('alert', ['type' => 'success', 'message' => 'Route Deleted Successfully']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $routes = Route::where('route_name', 'LIKE', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->latest()->paginate(50);

        return view('livewire.routes', ['routes' => $routes]);
    }
}
