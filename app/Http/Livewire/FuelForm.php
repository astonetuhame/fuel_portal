<?php

namespace App\Http\Livewire;

use App\Models\Lpo;
use App\Models\Fuel;
use App\Models\Route;
use App\Models\Truck;
use App\Models\Loading;
use App\Models\Station;
use Livewire\Component;

class FuelForm extends Component
{
    public $truck_id, $route_id, $loading_date;
    public $tripID;
    public $truckSearch = '';
    public $routeSearch = '';
    public $stationSearch = '';

    protected $listeners = ['getTripID', 'forcedClosedModal'];

    public function getTripID($tripID)
    {
        $this->tripID = $tripID;

        $model = Loading::find($this->tripID);

        // $reg_no = Truck::select('id')->where('truck_id', $model->truck_id)->get();
        // $route_name = Route::select('id')->where('route_id', $model->route_id)->get();

        $this->truck_id = $model->truck_id;
        $this->route_id = $model->route_id;
        $this->loading_date = $model->loading_date;
    }

    public function selectTruck($truck_id)
    {

        $this->truck_id = $truck_id;
        $this->truckSearch = '';
    }

    public function selectRoute($route_id)
    {

        $this->route_id = $route_id;
        $this->routeSearch = '';
    }

    // public function selectStation($station_id)
    // {

    // $this->station_id = $station_id;
    // $this->stationSearch='';
    // }

    public function forcedClosedModal()
    {
        //reset public variables
        $this->resetInputFields();

        //reset validation errors
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->tripID = null;
        $this->truck_id = null;
        $this->route_id = null;
        $this->loading_date = null;
    }

    public function addTrip()
    {

        $this->validate([
            'truck_id' => 'required',
            'route_id' => 'required',
            'loading_date' => 'required',
        ]);


        $validatedData = [
            'truck_id' => $this->truck_id,
            'route_id' => $this->route_id,
            'loading_date' => $this->loading_date,
        ];

        // dd($validatedData);

        if ($this->tripID) {
            $test = Lpo::where('loading_id', $this->tripID)->with('loadings')->get();
            // dd($test);
            Loading::where('id', $this->tripID)->update($validatedData);
            if ($test) {
                foreach ($test as $a) {
                    $a->loadings()->sync([$this->tripID => ['loading_date' => $this->loading_date]]);
                }
            }
            $this->emit('alert', ['type' => 'success', 'message' => 'Updated Successfully']);
        } else {
            Loading::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }
    public function render()
    {
        $searchTrucks = [];
        $searchRoutes = [];
        $searchStations = [];

        if (strlen($this->truckSearch) >= 2) {
            $searchTrucks = Truck::where('truck_no', 'LIKE', '%' . $this->truckSearch . '%')
                ->orderBy('truck_no', 'asc')->get();
        }

        if (strlen($this->routeSearch) >= 2) {
            $searchRoutes = Route::where('route_name', 'LIKE', '%' . $this->routeSearch . '%')
                ->orderBy('route_name', 'asc')->get();
        }

        // if(strlen($this->stationSearch)>=2){
        //     $searchStations = Station::where('name', 'LIKE' , '%'.$this->stationSearch.'%')
        //     ->get();
        //     }

        $trucks = Truck::orderBy('truck_no', 'asc')->get();

        $routes = Route::orderBy('route_name', 'asc')->get();

        $stations = Station::all();

        return view('livewire.fuel-form', compact('searchTrucks', 'trucks', 'routes', 'searchRoutes', 'stations', 'searchStations'));
    }
}
