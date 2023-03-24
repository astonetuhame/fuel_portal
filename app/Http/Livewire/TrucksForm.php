<?php

namespace App\Http\Livewire;

use App\Models\Truck;
use Livewire\Component;

class TrucksForm extends Component
{
    public $truck_no, $type;
    public $truckID;

    protected $listeners = ['getTruckID', 'forcedClosedModal'];

    public function getTruckID($truckID)
    {
        $this->truckID = $truckID;

        $model = Truck::find($this->truckID);

        $this->truck_no = $model->truck_no;
        $this->type = $model->type;
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
        $this->truckID = null;
        $this->truck_no = null;
        $this->type = null;
    }

    public function addTruck()
    {

        $this->validate([
            'truck_no' => 'required',
            'type' => 'required',
        ]);

        $validatedData = [
            'truck_no' => $this->truck_no,
            'type' => $this->type,
        ];

        if ($this->truckID) {
            Truck::find($this->truckID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Truck Updated Successfully']);
        } else {
            Truck::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Truck Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.trucks-form');
    }
}
