<?php

namespace App\Http\Livewire;

use App\Models\Local;
use App\Models\Truck;
use Livewire\Component;

class LocalForm extends Component
{
    public $truck_id;
    public $localID;
    public $truckSearch = '';

    protected $listeners = ['getLocalID', 'forcedClosedModal'];

    public function getLocalID($localID)
    {
        $this->localID = $localID;

        $model = Local::find($this->localID);


        $this->truck_id = $model->truck_id;
    }

    public function selectTruck($truck_id)
    {

        $this->truck_id = $truck_id;
        $this->truckSearch = '';
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
        $this->localID = null;
        $this->truck_id = null;
    }

    public function addLocal()
    {

        $this->validate([
            'truck_id' => 'required',
        ]);


        $validatedData = [
            'truck_id' => $this->truck_id,
        ];

        // dd($validatedData);

        if ($this->localID) {
            Local::where('id', $this->localID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Updated Successfully']);
        } else {
            Local::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        $searchTrucks = [];

        if (strlen($this->truckSearch) >= 2) {
            $searchTrucks = Truck::where('truck_no', 'LIKE', '%' . $this->truckSearch . '%')
                ->orderBy('truck_no', 'asc')->get();
        }

        $trucks = Truck::orderBy('truck_no', 'asc')->get();


        return view('livewire.local-form', compact('searchTrucks', 'trucks'));
    }
}
