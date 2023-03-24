<?php

namespace App\Http\Livewire;

use App\Models\Truck;
use App\Models\Reason;
use App\Models\NonTrip;
use Livewire\Component;

class NonTripsForm extends Component
{
    public $truck_id, $reason_id, $date;
    public $tripID;
    public $truckSearch = '';
    public $reasonSearch = '';

    protected $listeners = ['getTripID', 'forcedClosedModal'];

    public function getTripID($tripID)
    {
        $this->tripID = $tripID;

        $model = NonTrip::find($this->tripID);


        $this->truck_id = $model->truck_id;
        $this->reason_id = $model->reason_id;
        $this->date = $model->date;
    }

    public function selectTruck($truck_id)
    {

        $this->truck_id = $truck_id;
        $this->truckSearch = '';
    }

    public function selectRoute($reason_id)
    {

        $this->reason_id = $reason_id;
        $this->reasonSearch = '';
    }



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
        $this->reason_id = null;
        $this->date = null;
    }

    public function addTrip()
    {

        $this->validate([
            'truck_id' => 'required',
            'reason_id' => 'required',
            'date' => 'required',
        ]);


        $validatedData = [
            'truck_id' => $this->truck_id,
            'reason_id' => $this->reason_id,
            'date' => $this->date,
        ];

        dd($validatedData);

        if ($this->tripID) {
            NonTrip::find($this->tripID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Updated Successfully']);
        } else {
            NonTrip::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }


    public function render()
    {
        $searchTrucks = [];
        $searchReasons = [];

        if (strlen($this->truckSearch) >= 2) {
            $searchTrucks = Truck::where('truck_no', 'LIKE', '%' . $this->truckSearch . '%')
                ->get();
        }

        if (strlen($this->reasonSearch) >= 2) {
            $searchRoutes = Reason::where('reason', 'LIKE', '%' . $this->reasonSearch . '%')
                ->get();
        }

        $trucks = Truck::all();

        $reasons = Reason::all();


        return view('livewire.non-trips-form', compact('searchTrucks', 'trucks', 'reasons', 'searchReasons'));
    }
}
