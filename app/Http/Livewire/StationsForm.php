<?php

namespace App\Http\Livewire;

use App\Models\Station;
use Livewire\Component;

class StationsForm extends Component
{
    public $name, $rate, $currency, $quantity;
    public $stationID;

    protected $listeners = ['getStationID', 'forcedClosedModal'];

    public function getStationID($stationID)
    {
        $this->stationID = $stationID;

        $model = Station::find($this->stationID);

        $this->name = $model->name;
        $this->rate = $model->rate;
        $this->currency = $model->currency;
        $this->quantity = $model->quantity;
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
        $this->stationID = null;
        $this->name = null;
        $this->rate = null;
        $this->currency = null;
        $this->quantity = null;
    }

    public function addStation()
    {

        $this->validate([
            'name' => 'required',
            'rate' => 'required',
            'currency' => 'required',
        ]);

        $validatedData = [
            'name' => $this->name,
            'rate' => $this->rate,
            'currency' => $this->currency,
            'quantity' => $this->quantity,
        ];

        if ($this->stationID) {
            Station::find($this->stationID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Station Updated Successfully']);
        } else {
            Station::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Station Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.stations-form');
    }
}
