<?php

namespace App\Http\Livewire;

use App\Models\Distance;
use Livewire\Component;

class AddDistanceForm extends Component
{
    public $distance_date, $odometer;
    public $distanceID;
    public $local;



    protected $listeners = ['getDistanceID', 'forcedClosedModal'];


    public function getDistanceID($distanceID)
    {
        $this->distanceID = $distanceID;

        $model = Distance::find($this->distanceID);

        $this->distance_date = $model->date;
        $this->odometer = $model->odometer;
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
        $this->distanceID = null;
        $this->distance_date = null;
        $this->odometer = null;
    }

    public function addDistance()
    {

        $this->validate([
            'distance_date' => 'required',
            'odometer' => 'required',
        ]);


        $validatedData = [
            'local_id' => $this->local->id,
            'date' => $this->distance_date,
            'odometer' => $this->odometer,
        ];

        if ($this->distanceID) {
            Distance::find($this->distanceID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Updated Successfully']);
        } else {

            $distance = Distance::create($validatedData);
            $distance->locals()->attach($this->local->id);


            $this->emit('alert', ['type' => 'success', 'message' => 'Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.add-distance-form');
    }
}
