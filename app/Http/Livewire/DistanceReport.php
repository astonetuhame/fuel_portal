<?php

namespace App\Http\Livewire;

use App\Models\Local;
use Livewire\Component;
use App\Models\Distance;
use Livewire\WithPagination;

class DistanceReport extends Component
{
    use WithPagination;

    public $search = '';


    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        $search = $this->search;

        // $distances = Distance::groupBy('local_id')->with('local')->whereHas('local.truck', function ($q) use ($search) {
        //     $q->where('truck_no', 'like', '%' . $search . '%');
        // })->paginate(50);
        $distances = Local::groupBy('id')->with('distances', 'truck')->paginate(50);
        $test = Local::groupBy('id')->with('distances')->pluck('id');
        // dd($distances);

        $fin = Distance::select('odometer','local_id')->whereIn('local_id', $test)->get();
        // dd(collect($fin));
            
        return view('livewire.distance-report', compact('distances','fin'));
    }
}
