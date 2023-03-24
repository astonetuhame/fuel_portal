<?php

namespace App\Http\Livewire;

use App\Models\Fuel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class FuelReport extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function render()
    {
        $sum = Fuel::groupBy('date','route','truck_no')
                        ->selectRaw('sum(quantity) as sum, truck_no, date, route, station')
                        ->where('truck_no', 'LIKE', "%{$this->search}%")
                        ->paginate(20);
        // dd($sum);

       $reports = Fuel::get();

        return view('livewire.fuel-report', compact('sum', 'reports'));
    }
}
