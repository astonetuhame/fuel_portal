<?php

namespace App\Http\Livewire;

use App\Models\Route;
use Livewire\Component;

class RoutesForm extends Component
{
    public $route_code, $route_name, $destination_country, $single_diff, $double_diff;
    public $routeID;

    protected $listeners = ['getRouteID', 'forcedClosedModal'];

    public function getRouteID($routeID)
    {
        $this->routeID = $routeID;

        $model = Route::find($this->routeID);

        $this->route_code = $model->route_code;
        $this->route_name = $model->route_name;
        $this->destination_country = $model->destination_country;
        $this->single_diff = $model->single_diff;
        $this->double_diff = $model->double_diff;
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
        $this->routeID = null;
        $this->route_code = null;
        $this->route_name = null;
        $this->destination_country = null;
        $this->single_diff = null;
        $this->double_diff = null;
    }

    public function addRoute()
    {

        $this->validate([
            'route_code' => 'required',
            'route_name' => 'required',
            'destination_country' => 'required',
            'single_diff' => 'required',
            'double_diff' => 'required',
        ]);

        $validatedData = [
            'route_code' => $this->route_code,
            'route_name' => $this->route_name,
            'destination_country' => $this->destination_country,
            'single_diff' => $this->single_diff,
            'double_diff' => $this->double_diff,
        ];

        if ($this->routeID) {
            Route::find($this->routeID)->update($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Route Updated Successfully']);
        } else {
            Route::create($validatedData);
            $this->emit('alert', ['type' => 'success', 'message' => 'Route Added Successfully']);
        }

        $this->emit('refreshParent');
        $this->emit('closeFormModal');



        $this->resetInputFields();
    }

    public function render()
    {
        return view('livewire.routes-form');
    }
}
